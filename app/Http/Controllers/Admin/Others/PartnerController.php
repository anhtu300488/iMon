<?php

namespace App\Http\Controllers\Admin\Others;

use App\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PartnerController extends Controller
{
    public function index(Request $request){

        $partnerName = \Request::get('partnerName');
        $userName = \Request::get('userName');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = Partner::query();
        if($partnerName != ''){
            $query->where('partnerName','LIKE','%'.$partnerName.'%');
        }

        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('partnerId')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.others.partner.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.others.partner.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'partnerName' => 'required|max:50',
            'smsNumber' => 'max:4|integer',
            'userName' => 'max:20',
            'password' => 'max:255',
            'accessKey1' => 'max:255',
            'accessKey2' => 'max:255'
        ]);


        $input = $request->all();
//        $input['password'] = bcrypt($request->get('password'));
        $input['admin_id'] = Auth::user()->id;
        Partner::create($input);

        return redirect()->route('partner.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $partner = Partner::find($id);

        return view('admin.others.partner.edit',compact('partner'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'partnerName' => 'required|max:50',
            'smsNumber' => 'max:4|integer',
            'userName' => 'max:20',
            'password' => 'max:255',
            'accessKey1' => 'max:255',
            'accessKey2' => 'max:255'
        ]);

        $partner = Partner::find($id);
        $partner->partnerName = $request->input('partnerName');
        $partner->smsNumber = $request->input('smsNumber');
        $partner->userName = $request->input('userName');
        $partner->accessKey1 = $request->get('accessKey1');
        $partner->accessKey2 = $request->input('accessKey2');
        $partner->admin_id = Auth::user()->id;
        $partner->save();

        return redirect()->route('partner.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        Partner::find($id)->delete();
        return redirect()->route('partner.index')
            ->with('message','Deleted Successfully');
    }
}
