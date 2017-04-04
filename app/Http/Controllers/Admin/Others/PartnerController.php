<?php

namespace App\Http\Controllers\Admin\Others;

use App\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function index(Request $request){

        $partnerName = \Request::get('partnerName');
        $userName = \Request::get('userName');

        $query = Partner::query();
        if($partnerName != ''){
            $query->where('partnerName','LIKE','%'.$partnerName.'%');
        }

        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $data = $query->orderBy('partnerId')->paginate(10);

        return view('admin.others.partner.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        return view('admin.others.partner.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'partnerName' => 'required',
            'smsNumber' => 'required',
            'userName' => 'required',
            'password' => 'required',
            'accessKey1' => 'required',
            'accessKey2' => 'required'
        ]);


        $input = $request->all();
//        $input['password'] = bcrypt($request->get('password'));
        $input['admin_id'] = Auth::user()->id;
        Partner::create($input);

        return redirect()->route('partner.index')
            ->with('success','Add Partner successfully');
    }

    public function edit($id){
        $partner = Partner::find($id);

        return view('admin.others.partner.edit',compact('partner'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'partnerName' => 'required',
            'smsNumber' => 'required',
            'userName' => 'required',
            'password' => 'required',
            'accessKey1' => 'required',
            'accessKey2' => 'required'
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
            ->with('success','Gift Event updated successfully');
    }

    public function destroy($id){
        Partner::find($id)->delete();
        return redirect()->route('partner.index')
            ->with('success','Gift Event deleted successfully');
    }
}
