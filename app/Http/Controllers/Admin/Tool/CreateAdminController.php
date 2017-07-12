<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Admin;
use App\Cp;
use App\Provider;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminController extends Controller
{
    public function index(Request $request){
        $username = \Request::get('username');
        $status = \Request::get('status');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        $query = Admin::query();
        if($username != ''){
            $query->where('username','LIKE','%'.$username.'%');
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('id','desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.tool.createAdmin.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        $roles = Role::pluck('display_name','id');
        $cp = Cp::where('cpId','!=', 1)->pluck('cpName','cpId');
        return view('admin.tool.createAdmin.create',compact('roles','cp'));
    }

    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:admin',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required',
            'roles' => 'required',
            'cp' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['cp_id'] = $input['cp'];
        $input['status'] = 1;

        $user = Admin::create($input);
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('createAdmin.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $admin = Admin::find($id);
        $roles = Role::pluck('display_name','id');
        $cp = Cp::where('cpId','!=', 1)->pluck('cpName','cpId');
        $rolePermissions = $admin->roles->pluck('id','id')->toArray();
//        var_dump($rolePermissions);die;
        return view('admin.tool.createAdmin.edit',compact('admin','roles','rolePermissions','cp'));
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
            'name' => 'required',
            'email' => 'required|email|unique:admin,email,'.$id,
//            'password' => 'required',
            'roles' => 'required',
            'cp' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $user = Admin::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id',$id)->delete();


        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('createAdmin.index')
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
        Admin::find($id)->delete();
        return redirect()->route('createAdmin.index')
            ->with('message','Deleted Successfully');
    }
}
