<?php

namespace App\Http\Controllers\Admin\Others;

use App\EventImage;
use App\QuickTip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Cp;

class EventImageController  extends Controller
{
    public function index(Request $request){

        $content = \Request::get('content');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = EventImage::query();
        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
        }
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;

        if($cp != null){
            $query->where('cp','=', $cp);
            $partner_qr->where('cpId', '=', $cp);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');
        $partner->prepend('---Tất cả---', '');

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('tipId', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.others.eventImage.index',compact('data', 'partner'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
            $partner = $partner_qr->pluck('cpName', 'cpId');
        } elseif (Auth::user()->cp_id > 0){
            $partner_qr->where("cpId", "=" , Auth::user()->cp_id);
            $partner = $partner_qr->pluck('cpName', 'cpId');
        } else {
            $partner = $partner_qr->pluck('cpName', 'cpId');
            $partner->prepend('---Tất cả---', '');
        }

        return view('admin.others.eventImage.create',compact('partner'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'content' => 'required|max:400',
        ]);
        $input = $request->all();
        EventImage::create($input);
        return redirect()->route('eventEmage.index')
            ->with('message','Updated Successfully');;
    }

    public function edit($id){
        $partner_qr =  Cp::where('cpId','!=', 1);
        $event = EventImage::find($id);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
        }

        if($event->cp >0){
            $partner_qr->where("cpId",'=',  $tip->cp);
            $partner = $partner_qr->pluck('cpName', 'cpId');
        } else {
            $partner = $partner_qr->pluck('cpName', 'cpId');
            $partner->prepend('---Tất cả---', '');
        }

        return view('admin.others.eventImage.edit',compact('event ', 'partner'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'content' => 'required|max:400',
        ]);
        $tip = QuickTip::find($id);
        $tip->content = $request->input('content');
        $tip->active = $request->input('active');
        $tip->cp = $request->input('partner');
        $tip->save();
        return redirect()->route('tip.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        QuickTip::find($id)->delete();
        return redirect()->route('tip.index')
            ->with('message','Deleted Successfully');
    }
}
