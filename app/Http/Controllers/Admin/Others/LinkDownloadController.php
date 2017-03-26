<?php

namespace App\Http\Controllers\Admin\Others;

use App\TaiGame;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkDownloadController extends Controller
{
    public function index(Request $request){

        $os = \Request::get('os');
        $versionBuild = \Request::get('versionBuild');

        $matchThese = [];
        if($os != ''){
            $matchThese['clientId'] = $os;
        }

        if($versionBuild != ''){
            $matchThese['version_build'] = $versionBuild;
        }

        $query = TaiGame::query();

        $query->where($matchThese);

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.others.linkDownload.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){

        $osBuild = array(0 => 'Android', 1 => 'IOS', 2 => 'Window Phone', 3 => 'Desktop');
        $downloadType = array(0 => 'Qua Store', 1 => 'Tải file');
        return view('admin.others.linkDownload.create', compact('osBuild', 'downloadType'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'eventName' => 'required',
            'cashValue' => 'required',
            'goldValue' => 'required',
            'expiredTime' => 'required',
            'description' => 'required'
        ]);


        $input = $request->all();
        $input['expiredTime'] = date('Y-m-d',strtotime($request->get('expiredTime')));
        TaiGame::create($input);

        return redirect()->route('linkDownload.index')
            ->with('success','Add Gift Event successfully');
    }

    public function edit($id){
        $eventGift = TaiGame::find($id);

        return view('admin.others.linkDownload.edit',compact('eventGift'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'eventName' => 'required',
            'cashValue' => 'required',
            'goldValue' => 'required',
            'expiredTime' => 'required',
            'description' => 'required'
        ]);

        $giftEvent = TaiGame::find($id);
        $giftEvent->eventName = $request->input('eventName');
        $giftEvent->cashValue = $request->input('cashValue');
        $giftEvent->goldValue = $request->input('goldValue');
        $giftEvent->expiredTime = date('Y-m-d',strtotime($request->get('expiredTime')));
        $giftEvent->description = $request->input('description');
        $giftEvent->save();

        return redirect()->route('linkDownload.index')
            ->with('success','Gift Event updated successfully');
    }

    public function destroy($id){
        TaiGame::find($id)->delete();
        return redirect()->route('linkDownload.index')
            ->with('success','Gift Event deleted successfully');
    }
}
