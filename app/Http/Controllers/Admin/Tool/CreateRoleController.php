<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CreateRoleController extends Controller
{
    public function index(Request $request){
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = Role::orderBy('id','DESC')->paginate($perPage);
        return view('admin.tool.role.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        $permission = Permission::get();
        return view('admin.tool.role.create',compact('permission'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('tool.roles')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$id)
            ->pluck('permission_role.permission_id','permission_role.permission_id');

        return view('admin.tool.role.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        DB::table("permission_role")->where("permission_role.role_id",$id)
            ->delete();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('tool.roles')
            ->with('message','Update Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('tool.roles')
            ->with('message','Deleted Successfully');
    }
}
