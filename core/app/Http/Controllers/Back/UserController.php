<?php

namespace App\Http\Controllers\Back;

use App\{
    Models\User,
    Http\Controllers\Controller
};
use App\Helpers\ImageHelper;
use App\Http\Requests\UserRequest;
use App\Models\Subscriber;
use App\Helpers\EmailHelper;
use App\Jobs\EmailSendJob;
use App\Models\Setting;
use App\Repositories\Front\UserRepository;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     * @param  \App\Repositories\Back\UserRepository $repository
     *
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('back.user.index', [
            'datas' => User::latest()->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('back.user.show', compact('user'));
    }
    public function create()
    {
        return view('back.user.create');
    }


    public function store(UserRequest $request)
    {
        //dd($request);
        $validated = $request->validate([
            'first_name'   => 'nullable|string|max:100',
            'last_name'    => 'nullable|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'gst_number' => 'required|string|max:100',
            'msme_number' => 'nullable|string|max:100',
            'brand_type'        => 'nullable|string|max:20',
            'bill_address1' => 'required|string|max:100',
            'bill_address2' => 'nullable|string|max:100',
            'bill_zip' => 'required|numeric|digits:6',
            'bill_city' => 'required|string|max:100',
            'bill_country' => 'required|string|max:100',
            'password'     => 'required|min:6|max:10',
            'bill_company' => 'required|string|max:100',
            'adharcard' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'pancard'   => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'gstdoc'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'extradoc'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
        ]);

        $user = new User();
        $user->first_name   = $validated['first_name'];
        $user->last_name    = $validated['last_name'] ?? '';
        $user->email        = $validated['email'];
        $user->phone        = $validated['phone'] ?? '';
        $user->gst_number   = $validated['gst_number'] ?? '';
        $user->msme_number  = $validated['msme_number'] ?? '';
        $user->tag        = $validated['brand_type'] ?? '';
        $user->bill_address1        = $validated['bill_address1'] ?? '';
        $user->bill_address2        = $validated['bill_address2'] ?? '';
        $user->bill_zip        = $validated['bill_zip'] ?? '';
        $user->bill_city        = $validated['bill_city'] ?? '';
        $user->bill_country        = $validated['bill_country'] ?? '';
        $user->bill_company = $validated['bill_company'] ?? '';
        $user->password     = bcrypt($validated['password']);

        // Handle files and store paths in JSON
        $documents = [];
        // $documents = [];

        if ($request->hasFile('adharcard')) {
            $file = $request->file('adharcard');
            $filename = time() . '_adhar.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/adharcard'), $filename);
            $documents['adharcard'] = 'user_doc/adharcard/' . $filename;
        }

        if ($request->hasFile('pancard')) {
            $file = $request->file('pancard');
            $filename = time() . '_pan.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/pancard'), $filename);
            $documents['pancard'] = 'user_doc/pancard/' . $filename;
        }

        if ($request->hasFile('gstdoc')) {
            $file = $request->file('gstdoc');
            $filename = time() . '_gst.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/gstdoc'), $filename);
            $documents['gstdoc'] = 'user_doc/gstdoc/' . $filename;
        }

        if ($request->hasFile('extradoc')) {
            $file = $request->file('extradoc');
            $filename = time() . '_extra.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/extradoc'), $filename);
            $documents['extradoc'] = 'user_doc/extradoc/' . $filename;
        }


        $user->documents = json_encode($documents);
        $user->save();

        $setting = Setting::first();
        // Helper function for N/A
        function na($value)
        {
            return empty($value) ? 'N/A' : $value;
        }

        $emailData = [
            'to' => $user->email,
            'subject' => "Welcome to Ferranza – Your Registration Details",
            'body' => "
        Dear " . na($user->first_name) . ",<br><br>

        Welcome to Ferranza EV!<br>
        Your account has been successfully created.<br><br>

        Please find your login credentials below:<br><br>

        <b>Login Email:</b> " . na($user->email) . "<br>
        <b>Password:</b> " . na($request->password) . "<br><br>

        You can now log in to your Ferranza EV dashboard using the above details.<br>
        If you face any issues while logging in, feel free to contact us—we’re happy to help.<br><br>

        Thank you for choosing Ferranza EV!<br><br>

        Warm regards,<br>
        Ferranza EV Team
    "
        ];


        if ($setting->smtp_check) {
            if ($setting->is_queue_enabled == 1) {
                dispatch(new EmailSendJob($emailData));
            } else {
                $email = new EmailHelper();
                $email->sendCustomMail($emailData, "custom");
            }
        }

        return redirect()->route('back.user.index')->withSuccess(__('New Customer Added Successfully.'));
    }
    // public function update(UserRequest $request)
    // {
    //     $request->validate([
    //         'password' => 'min:6|max:16|nullable'
    //     ]);
    //     $this->repository->profileUpdate($request);
    //     return redirect()->back()->withSuccess(__('Profile Updated Successfully.'));

    // }
    public function update(UserRequest $request, $id)
    {
        $request->validate([
            'first_name'   => 'nullable|string|max:100',
            'last_name'    => 'nullable|string|max:100',
            'email'        => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $id,
            'gst_number' => 'required|string|max:100',
            'msme_number' => 'nullable|string|max:100',
            'brand_type'        => 'nullable|string',
            'password'     => 'required|min:6|max:10',
            'bill_company' => 'required|string|max:100',
            'bill_address1' => 'required|string|max:100',
            'bill_address2' => 'nullable|string|max:100',
            'bill_zip' => 'required|numeric|digits:6',
            'bill_city' => 'required|string|max:100',
            'bill_country' => 'required|string|max:100',
            'adharcard' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'pancard'   => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'gstdoc'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'extradoc'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
        ]);

        $user = User::findOrFail($id);

        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name ?? '';
        $user->email        = $request->email;
        $user->phone        = $request->phone ?? '';
        $user->gst_number    = $request->gst_number ?? '';
        $user->msme_number    = $request->msme_number ?? '';
        $user->tag       = $request->brand_type ?? '';
        $user->bill_address1 = $request->bill_address1 ?? '';
        $user->bill_address2 = $request->bill_address2 ?? '';
        $user->bill_zip = $request->bill_zip ?? '';
        $user->bill_city = $request->bill_city ?? '';
        $user->bill_country = $request->bill_country ?? '';
        $user->bill_company = $request->bill_company ?? '';

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Get existing documents
        $documents = json_decode($user->documents, true) ?? [];

        // Handle file uploads and replace existing files if new ones are uploaded
        if ($request->hasFile('adharcard')) {
            $file = $request->file('adharcard');
            $filename = time() . '_adhar.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/adharcard'), $filename);
            $documents['adharcard'] = 'user_doc/adharcard/' . $filename;
        }

        if ($request->hasFile('pancard')) {
            $file = $request->file('pancard');
            $filename = time() . '_pan.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/pancard'), $filename);
            $documents['pancard'] = 'user_doc/pancard/' . $filename;
        }

        if ($request->hasFile('gstdoc')) {
            $file = $request->file('gstdoc');
            $filename = time() . '_gst.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/gstdoc'), $filename);
            $documents['gstdoc'] = 'user_doc/gstdoc/' . $filename;
        }

        if ($request->hasFile('extradoc')) {
            $file = $request->file('extradoc');
            $filename = time() . '_extra.' . $file->getClientOriginalExtension();
            $file->move(public_path('user_doc/extradoc'), $filename);
            $documents['extradoc'] = 'user_doc/extradoc/' . $filename;
        }

        $user->documents = json_encode($documents);
        $user->save();

        return redirect()->back()->withSuccess(__('Profile Updated Successfully.'));
    }
    // public function exportCSV()
    // {
    //     $users = DB::table('users')->get();

    //     $filename = 'customers_' . now()->format('Y_m_d_H_i_s') . '.csv';

    //     $headers = [
    //         "Content-Type"        => "text/csv; charset=UTF-8",
    //         "Content-Disposition" => "attachment; filename=$filename",
    //         "Pragma"              => "no-cache",
    //         "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
    //         "Expires"             => "0"
    //     ];

    //     $columns = [
    //         'ID','First Name','Last Name','Phone','Email',
    //         'Shipping Address1','Shipping Address2','Shipping Zip','Shipping City','Shipping Country','Shipping Company',
    //         'Billing Address1','Billing Address2','Billing Zip','Billing City','Billing Country','Billing Company',
    //         'State ID','Email Verify','Company Name','Created At','Updated At'
    //     ];

    //     $callback = function() use ($users, $columns) {
    //         $file = fopen('php://output', 'w');

    //         // UTF-8 BOM for Excel
    //         fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

    //         // Header
    //         fputcsv($file, $columns);

    //         foreach ($users as $user) {
    //             fputcsv($file, [
    //                 $user->id,
    //                 $user->first_name,
    //                 $user->last_name,
    //                 $user->phone,
    //                 $user->email,
    //                 // $user->photo,
    //                 // $user->email_token,
    //                 $user->ship_address1,
    //                 $user->ship_address2,
    //                 $user->ship_zip,
    //                 $user->ship_city,
    //                 $user->ship_country,
    //                 $user->ship_company,
    //                 $user->bill_address1,
    //                 $user->bill_address2,
    //                 $user->bill_zip,
    //                 $user->bill_city,
    //                 $user->bill_country,
    //                 $user->bill_company,
    //                 $user->state_id,
    //                 $user->email_verify,
    //                 $user->company_name,
    //                 // $user->documents,
    //                 // Format dates using Carbon
    //                 $user->created_at ? Carbon::parse($user->created_at)->format('d M Y h:i A') : '',
    //                 $user->updated_at ? Carbon::parse($user->updated_at)->format('d M Y h:i A') : '',
    //             ]);
    //         }

    //         fclose($file);
    //     };

    //     return Response::stream($callback, 200, $headers);
    // }
    public function exportCSV()
    {
        // Only get necessary fields
        $users = DB::table('users')->select(
            'id',
            'bill_company',
            'first_name',
            'email',
            'gst_number',
            'msme_number',
            'phone',
            'bill_address1',
            'bill_address2',
            'bill_zip',
            'bill_city',
            'bill_country',
            'tag',
            'email_verify',
            'state_id',
            'created_at',
            'updated_at'
        )->get();

        $filename = 'customers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID',
            'Company Name',
            'Name',
            'Email',
            'GST Number',
            'MSME Number',
            'Phone',
            'Address1',
            'Address2',
            'ZipCode',
            'City',
            'Country',
            'Type',
            'Email Verify',
            'State ID',
            'Created At',
            'Updated At'
        ];

        $callback = function () use ($users, $columns) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write header
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->bill_company,
                    $user->first_name,
                    $user->email,
                    $user->gst_number,
                    $user->msme_number,
                    $user->phone,
                    $user->bill_address1,
                    $user->bill_address2,
                    $user->bill_zip,
                    $user->bill_city,
                    $user->bill_country,
                    ($user->tag == 1 ? 'Branded' : 'Non-Branded'),
                    $user->email_verify,
                    $user->created_at ? Carbon::parse($user->created_at)->format('Y-m-d H:i:s') : '',
                    $user->updated_at ? Carbon::parse($user->updated_at)->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    public function importForm()
    {
        return view('back.user.import'); // create a Blade with file input
    }

    // public function importCSV(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:csv,txt',
    //     ]);

    //     try {
    //         $file = $request->file('file');

    //         // Store temporarily in public folder
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('uploads/temp'), $filename);
    //         $filePath = public_path('uploads/temp/' . $filename);

    //         if (!file_exists($filePath)) {
    //             return back()->withError('File not found.');
    //         }

    //         $handle = fopen($filePath, 'r');
    //         if (!$handle) {
    //             return back()->withError('Unable to open the CSV file.');
    //         }

    //         // Read header row
    //         $header = fgetcsv($handle);

    //         // Map CSV headers to DB columns
    //         $columnMap = [
    //             'ID'                  => 'id',
    //             'First Name'          => 'first_name',
    //             'Last Name'           => 'last_name',
    //             'Phone'               => 'phone',
    //             'Email'               => 'email',
    //             'Shipping Address1'   => 'ship_address1',
    //             'Shipping Address2'   => 'ship_address2',
    //             'Shipping Zip'        => 'ship_zip',
    //             'Shipping City'       => 'ship_city',
    //             'Shipping Country'    => 'ship_country',
    //             'Shipping Company'    => 'ship_company',
    //             'Billing Address1'    => 'bill_address1',
    //             'Billing Address2'    => 'bill_address2',
    //             'Billing Zip'         => 'bill_zip',
    //             'Billing City'        => 'bill_city',
    //             'Billing Country'     => 'bill_country',
    //             'Billing Company'     => 'bill_company',
    //             'State ID'            => 'state_id',
    //             'Email Verify'        => 'email_verify',
    //             'Company Name'        => 'company_name',
    //             'Created At'          => 'created_at',
    //             'Updated At'          => 'updated_at',
    //         ];

    //         while (($row = fgetcsv($handle)) !== false) {
    //             $data = [];

    //             foreach ($header as $index => $colName) {
    //                 $colName = trim($colName);
    //                 if (isset($columnMap[$colName])) {
    //                     $dbColumn = $columnMap[$colName];
    //                     $data[$dbColumn] = $row[$index] ?? null;
    //                 }
    //             }

    //             // Handle password default
    //             if (!empty($data['password'])) {
    //                 $data['password'] = bcrypt($data['password']);
    //             } else {
    //                 $data['password'] = bcrypt('123456');
    //             }

    //             // Insert or update by email
    //             DB::table('users')->updateOrInsert(
    //                 ['email' => $data['email']],
    //                 $data
    //             );
    //         }

    //         fclose($handle);

    //         // Delete temporary file
    //         unlink($filePath);

    //         return back()->withSuccess('Customers imported successfully!');
    //     } catch (\Throwable $e) {
    //         dd($e);
    //         return back()->withError('Something went wrong!');
    //     }
    // }

    public function importCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        try {
            $file = $request->file('file');

            // Store temporarily
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/temp'), $filename);
            $filePath = public_path('uploads/temp/' . $filename);

            if (!file_exists($filePath)) {
                return back()->withError('File not found.');
            }

            $handle = fopen($filePath, 'r');
            if (!$handle) {
                return back()->withError('Unable to open the CSV file.');
            }

            // Read header
            $header = fgetcsv($handle);
            if (!$header) {
                return back()->withError('CSV header missing.');
            }

            // Map CSV headers to DB columns
            $columnMap = [
                'ID'                  => 'id',
                'Company Name'        => 'bill_company',
                'Name'                => 'first_name',
                'Email'               => 'email',
                'GST Number'          => 'gst_number',
                'MSME Number'          => 'msme_number',
                'Phone'               => 'phone',
                'Password'            => 'password',
                'Address1'            => 'bill_address1',
                'Address2'            => 'bill_address2',
                'ZipCode'             => 'bill_zip',
                'City'                => 'bill_city',
                'Country'             => 'bill_country',
                'Type'                => 'tag',
                'Email Verify'        => 'email_verify',
                'Created At'          => 'created_at',
                'Updated At'          => 'updated_at',
            ];

            $inserted = 0;
            $updated = 0;
            $skipped = 0;

            while (($row = fgetcsv($handle)) !== false) {
                $data = [];

                foreach ($header as $index => $colName) {
                    $colName = trim($colName);
                    if (isset($columnMap[$colName])) {
                        $dbColumn = $columnMap[$colName];
                        $data[$dbColumn] = $row[$index] ?? null;
                    }
                }

                // Skip invalid rows (no email)
                if (empty($data['email'])) {
                    $skipped++;
                    continue;
                }

                // TYPE Conversion
                if (isset($data['tag'])) {
                    $type = trim($data['tag']);

                    if ($type === "Branded") {
                        $data['tag'] = 1;
                    } elseif ($type === "Non-Branded") {
                        $data['tag'] = 0;
                    } else {
                        $data['tag'] = is_numeric($type) ? intval($type) : 0;
                    }
                } else {
                    $data['tag'] = 0;
                }


                // Password handling
                $data['password'] = !empty($data['password'])
                    ? bcrypt($data['password'])
                    : bcrypt('123456');

                // Default values
                $data['email_verify'] = $data['email_verify'] ?? 0;
                $data['tag'] = $data['tag'] ?? 0;

                // Timestamps
                $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : now();
                $data['updated_at'] = !empty($data['updated_at']) ? $data['updated_at'] : now();

                // Insert/update logic
                if (!empty($data['id'])) {
                    // If ID provided, update by ID
                    $exists = DB::table('users')->where('id', $data['id'])->exists();

                    if ($exists) {
                        DB::table('users')->where('id', $data['id'])->update($data);
                        $updated++;
                    } else {
                        unset($data['id']); // Remove ID for auto-increment insert
                        DB::table('users')->insert($data);
                        $inserted++;
                    }
                } else {
                    // Otherwise update or insert by email
                    $exists = DB::table('users')->where('email', $data['email'])->exists();
                    DB::table('users')->updateOrInsert(['email' => $data['email']], $data);

                    if ($exists) {
                        $updated++;
                    } else {
                        $inserted++;
                    }
                }
            }

            fclose($handle);
            unlink($filePath);

            return back()->withSuccess("Customers imported successfully! Inserted: $inserted | Updated: $updated | Skipped: $skipped");
        } catch (\Throwable $e) {
            dd($e);
            return back()->withError('Something went wrong while importing!');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        ImageHelper::handleDeletedImage($user, 'photo', 'images');
        $user->delete();
        return redirect()->route('back.user.index')->withSuccess(__('Customer Deleted Successfully.'));
    }

    public function changepassword(Request $request, $id)
    {

        try {
            // Validate password
            $request->validate([
                'changepassword' => 'required|min:6|max:10',
            ]);

            // Find user
            $user = User::findOrFail($id);
            //    dd($user);
            // Update password (hash )
            $user->password = bcrypt($request->changepassword);
            $user->save();

            $setting = Setting::first();

            $emailData = [
                'to' => $user->email,
                'subject' => "Password Change By Admin",
                'body' => "Your New Password is " . $request->changepassword,
            ];
            // dd( $emailData);
            if ($setting->smtp_check) {
                if ($setting->is_queue_enabled == 1) {
                    dispatch(new EmailSendJob($emailData));
                } else {
                    $email = new EmailHelper();
                    $email->sendCustomMail($emailData, "custom");
                }
            }

            return redirect()->route('back.user.index')->withSuccess(__('Password updated successfully.'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
