<?php

namespace App\Http\Controllers\Back;
use Illuminate\Support\Facades\Auth;

use App\{
    Models\Item,
    Models\Gallery,
    Http\Requests\ItemRequest,
    Http\Controllers\Controller,
    Http\Requests\GalleryRequest,
    Repositories\Back\ItemRepository
};
use App\Helpers\ImageHelper;
use App\Models\Category;
use App\Models\ChieldCategory;
use App\Models\Currency;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
class ItemController extends Controller
{

    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     * @param  \App\Repositories\Back\ItemRepository $repository
     *
     */
    public function __construct(ItemRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
        $this->repository = $repository;
    }


    public function summernoteUpload(Request $request)
    {
        $name = ImageHelper::uploadSummernoteImage($request->file('image'), 'images/summernote');

        return response()->json([
            'success' => true,
            'image' => url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/summernote/' . $name)
        ]);
    }


    public function add()
    {
        return view('back.item.add');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item_type = $request->has('item_type') ? ($request->item_type ? $request->item_type : '') : '';
        $is_type = $request->has('is_type') ? ($request->is_type ? $request->is_type : '') : '';
        $category_id = $request->has('category_id') ? ($request->category_id ? $request->category_id : '') : '';
        $orderby = $request->has('orderby') ? ($request->orderby ? $request->orderby : 'desc') : 'desc';

        $datas = Item::when($item_type, function ($query, $item_type) {
                return $query->where('item_type', $item_type);
            })
            ->when($is_type, function ($query, $is_type) {
                if ($is_type != 'outofstock') {
                    return $query->where('is_type', $is_type);
                } else {
                    return $query->whereStock(0)->whereItemType('normal');
                }
            })
            ->when($category_id, function ($query, $category_id) {
                return $query->where('category_id', $category_id);
            })
            ->when($orderby, function ($query, $orderby) {
                return $query->orderby('id', $orderby);
            })
            ->get();

        return view('back.item.index', [
            'datas' => $datas
        ]);
    }

    /**
     * Show the form for get subcategory a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getsubCategory(Request $request)
    {

        if ($request->category_id) {
            $data = Category::findOrFail($request->category_id);
            $data = $data->subcategory;
        } else {
            $data = [];
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for get subcategory a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChildCategory(Request $request)
    {

        if ($request->subcategory_id) {
            $data = Subcategory::findOrFail($request->subcategory_id);
            $data = $data->childcategory;
        } else {
            $data = [];
        }

        return response()->json(['data' => $data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.item.create', [
            'curr' => Currency::where('is_default', 1)->first()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item_id = $this->repository->store($request);

        if ($request->is_button == 0) {
            return redirect()->route('back.item.index')->withSuccess(__('Product Added Successfully.'));
        } else {
            return redirect(route('back.item.edit', $item_id))->withSuccess(__('Product Added Successfully.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('back.item.edit', [
            'item' => $item,
            'curr' => Currency::where('is_default', 1)->first(),
            'social_icons' => json_decode($item->social_icons, true),
            'social_links' => json_decode($item->social_links, true),
            'specification_name' => json_decode($item->specification_name, true),
            'specification_description' => json_decode($item->specification_description, true),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, Item $item)
    {
        $this->repository->update($item, $request);

        if ($request->is_button == 0) {
            return redirect()->route('back.item.index')->withSuccess(__('Product Updated Successfully.'));
        } else {
            return redirect()->back()->withSuccess(__('Product Updated Successfully.'));
        }
    }

    /**
     * Change the status for editing the specified resource.
     *
     * @param  int  $id
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function status(Item $item, $status)
    {
        $item->update(['status' => $status]);
        return redirect()->back()->withSuccess(__('Status Updated Successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $this->repository->delete($item);
        return redirect()->back()->withSuccess(__('Product Deleted Successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function galleries(Item $item)
    {
        return view('back.item.galleries', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\GalleryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function galleriesUpdate(GalleryRequest $request)
    {
        $this->repository->galleriesUpdate($request);
        return redirect()->back()->withSuccess(__('Gallery Information Updated Successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function galleryDelete(Gallery $gallery)
    {
        $this->repository->galleryDelete($gallery);
        return redirect()->back()->withSuccess(__('Successfully Deleted From Gallery.'));
    }


    public function highlight(Item $item)
    {
        return view('back.item.highlight', [
            'item' => $item
        ]);
    }
    public function highlight_update(Item $item, Request $request)
    {
        $this->repository->highlight($item, $request);
        return redirect()->route('back.item.index')->withSuccess(__('Product Updated Successfully.'));
    }




    // ---------------- DIGITAL PRODUCT START ---------------//

    public function deigitalItemCreate()
    {
        return view('back.item.digital.create', [
            'curr' => Currency::where('is_default', 1)->first()
        ]);
    }

    public function deigitalItemStore(ItemRequest $request)
    {
        $this->repository->store($request);
        return redirect()->route('back.item.index')->withSuccess(__('New Product Added Successfully.'));
    }

    public function deigitalItemEdit($id)
    {
        $item = Item::findOrFail($id);

        return view('back.item.digital.edit', [
            'item' => $item,
            'curr' => Currency::where('is_default', 1)->first(),
            'social_icons' => json_decode($item->social_icons, true),
            'social_links' => json_decode($item->social_links, true),
            'specification_name' => json_decode($item->specification_name, true),
            'specification_description' => json_decode($item->specification_description, true),
        ]);
    }


    // ---------------- LICENSE PRODUCT START ---------------//

    public function licenseItemCreate()
    {
        return view('back.item.license.create', [
            'curr' => Currency::where('is_default', 1)->first()
        ]);
    }

    public function licenseItemStore(ItemRequest $request)
    {
        $this->repository->store($request);
        return redirect()->route('back.item.index')->withSuccess(__('New Product Added Successfully.'));
    }

    public function licenseItemEdit($id)
    {
        $item = Item::findOrFail($id);

        return view('back.item.license.edit', [
            'item' => $item,
            'curr' => Currency::where('is_default', 1)->first(),
            'social_icons' => json_decode($item->social_icons, true),
            'social_links' => json_decode($item->social_links, true),
            'specification_name' => json_decode($item->specification_name, true),
            'specification_description' => json_decode($item->specification_description, true),
            'license_name' => json_decode($item->license_name, true),
            'license_key' => json_decode($item->license_key, true),
        ]);
    }


    // public function stockOut()
    // {
       
    //     $datas = Item::where('item_type', 'normal')->where('stock', 0)->get();
          
    //     return view('back.item.stockout', compact('datas'));
    // }
    
    public function stockOut()
{
    // Fetch stock out history with product & warehouse
    $stock_out_history = DB::table('stock_out')
        ->join('items', 'stock_out.product_id', '=', 'items.id')
        ->leftJoin('warehouses', 'stock_out.warehouse_id', '=', 'warehouses.id')
        ->select(
            'stock_out.*',
            'items.name as product_name',
            'warehouses.name as warehouse_name'
        )
        ->orderBy('stock_out.created_at', 'desc')
        ->get();

    return view('back.item.stockout', compact('stock_out_history'));
}

    
    
    public function stockIn()
{
    
    $datas = Item::where('item_type', 'normal')->get();

    // Fetch stock_in history with warehouse + product
    $stock_history = DB::table('stock_in')
        ->join('warehouses', 'stock_in.warehouse_id', '=', 'warehouses.id')
        ->join('items', 'stock_in.product_id', '=', 'items.id')
        ->select(
            'stock_in.*',
            'warehouses.name as warehouse_name',
            'items.name as product_name'
        )
        ->orderBy('stock_in.created_at', 'desc')
        ->get();

    return view('back.item.stock_in', compact('datas', 'stock_history'));
}
    
    
    
    public function updateStock(Request $request, $id)
{
    $request->validate([
        'warehouse_id' => 'required|exists:warehouses,id',
        'qty' => 'required|numeric|min:0',
    ]);

    // Save to a stock_in table or update item directly
    DB::table('stock_in')->insert([
        'product_id' => $id,
        'warehouse_id' => $request->warehouse_id,
        'qty' => $request->qty,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Optionally update item stock
    $item = Item::findOrFail($id);
    $item->stock += $request->qty;
    $item->save();

    return redirect()->back()->with('success', 'Stock updated successfully!');
}

public function updateStockout(Request $request, $id)
{
    $request->validate([
        'warehouse_id' => 'required|exists:warehouses,id',
        'qty' => 'required|numeric|min:0',
        'action' => 'nullable|in:edit,lock',
    ]);

    // Set lock status based on action
    $isLocked = $request->action === 'lock' ? 1 : 0;

    // Always create a new entry
    DB::table('stock_out')->insert([
        'product_id'   => $id,
        'warehouse_id' => $request->warehouse_id,
        'qty'          => $request->qty,
        'non_editable' => $isLocked,
        'out_status'   => Auth::user()->name ?? "Admin",
        'created_at'   => now(),
        'updated_at'   => now(),
    ]);

    // Update item stock (decrease by qty)
    $item = Item::findOrFail($id);
    $item->stock -= $request->qty;
    $item->save();

    return redirect()
        ->back()
        ->with('success', 'Stock out updated successfully!');
}

public function exportStockInCSV()
{
    $stock_history = DB::table('stock_in')
        ->join('warehouses', 'stock_in.warehouse_id', '=', 'warehouses.id')
        ->join('items', 'stock_in.product_id', '=', 'items.id')
        ->select(
            'items.name as product_name',
            'warehouses.name as warehouse_name',
            'stock_in.qty',
            'stock_in.created_at'
        )
        ->orderBy('stock_in.created_at', 'desc')
        ->get();

    if ($stock_history->isEmpty()) {
        return back()->with('error', 'No stock-in history available for export.');
    }

    $filename = 'stock_in_history_' . now()->format('Y_m_d_H_i_s') . '.csv';

    $headers = [
        "Content-Type"        => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['Product', 'Warehouse', 'Quantity Added', 'Date & Time'];

    $callback = function() use ($stock_history, $columns) {
        $file = fopen('php://output', 'w');

        // Add UTF-8 BOM to support special characters
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        // Write the header row
        fputcsv($file, $columns);

        foreach ($stock_history as $row) {
            fputcsv($file, [
                $row->product_name,
                $row->warehouse_name,
                $row->qty,
                // Force date as plain text
                '="' . Carbon::parse($row->created_at)->format('d M Y h:i A') . '"',
            ]);
        }

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}
public function exportStockOutCSV()
{
    $stock_out_history = DB::table('stock_out')
        ->join('items', 'stock_out.product_id', '=', 'items.id')
        ->leftJoin('warehouses', 'stock_out.warehouse_id', '=', 'warehouses.id')
        ->select(
            'items.name as product_name',
            'warehouses.name as warehouse_name',
            'stock_out.qty',
            'stock_out.created_at'
        )
        ->orderBy('stock_out.created_at', 'desc')
        ->get();

    if ($stock_out_history->isEmpty()) {
        return back()->with('error', 'No stock-out history available for export.');
    }

    $filename = 'stock_out_history_' . now()->format('Y_m_d_H_i_s') . '.csv';

    $headers = [
        "Content-Type"        => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['Product', 'Warehouse', 'Quantity Out', 'Date & Time'];

    $callback = function() use ($stock_out_history, $columns) {
        $file = fopen('php://output', 'w');

        // UTF-8 BOM (for Excel)
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header
        fputcsv($file, $columns);

        foreach ($stock_out_history as $row) {
            fputcsv($file, [
                $row->product_name,
                $row->warehouse_name ?? 'N/A',
                $row->qty,
                // Force date as readable text in Excel
                '="' . Carbon::parse($row->created_at)->format('d M Y h:i A') . '"',
            ]);
        }

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}

    
}
