<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Admin;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
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
        $data = $query->orderBy('id','desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.tool.createAdmin.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        $roles = Role::pluck('display_name','id');
        return view('admin.tool.createAdmin.create',compact('roles'));
    }

    public function store(Request $request){
//        $this->validate($request, [
//            'userId' => 'required|integer',
//            'addGold' => 'required|integer',
//            'addCash' => 'required|integer'
//        ]);
//
//        $addMoney = new AddMoney;
//
//        $addMoney->userId = $request->get('userId');
//        $addMoney->addGold = $request->get('addGold');
//        $addMoney->addCash = $request->get('addCash');
//        $addMoney->description = $request->get('description');
//        $addMoney->admin_id = Auth::user()->id;
//        $addMoney->status = 1;
//        $addMoney->created_at = Carbon::now();
//        $addMoney->updated_at = Carbon::now();
//        $addMoney->save();
//
//        return redirect()->route('tool.addMoney')
//            ->with('success','Add money successfully');

        $this->validate($request, [
            'name' => 'required',
            'name' => 'required|unique:admin',
            'email' => 'required|email',
            'password' => 'required',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['status'] = 1;

        $user = Admin::create($input);
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('tool.createAdmin')
            ->with('message','Add Successfully');
    }
}
