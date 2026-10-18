<?php

namespace App\Http\Controllers\Back;

use App\{
    Models\Role,
    Http\Controllers\Controller
};

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class RoleController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $roles = Role::orderBy('id', 'desc')->get();

        foreach ($roles as $role) {
            $role->decoded_section = json_decode($role->section, true);
        }
        return view('back.role.index',[
            'datas' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:roles,name',
        ]);

        $input = $request->all();
        $input['section'] = json_encode($request->section,true);

        Role::create($input);
        return redirect()->route('back.role.index')->withSuccess(__('New Role Added Successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('back.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => [
                'required',
                'max:100',
                // Rule::unique('categories', 'name')->ignore($id),
                 Rule::unique('roles', 'name')->ignore($id),
            ],
        ]);
         $role = Role::findOrFail($id);
        $input = $request->all();
        $input['section'] = json_encode($request->section,true);
       $role->update($input);
        return redirect()->route('back.role.index')->withSuccess(__('Role Updated Successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('back.role.index')->withSuccess(__('Role Deleted Successfully.'));
    }
}
