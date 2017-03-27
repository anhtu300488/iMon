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
            'os' => 'required',
            'link_tai' => 'required',
            'file_down' => 'required',
            'is_direct' => 'required',
            'status' => 'required',
            'file_down' => 'required|mimes:apk,ipa,exe,jpg,jpeg,png',
            'delay' => 'required'
        ]);


        $input = $request->all();
        $input['file_down'] = $request->file('file_down')->store('public');
        TaiGame::create($input);

        return redirect()->route('linkDownload.index')
            ->with('success','Add Gift Event successfully');
    }

    public function edit($id){
        $linkDownload = TaiGame::find($id);
        $osBuild = array(0 => 'Android', 1 => 'IOS', 2 => 'Window Phone', 3 => 'Desktop');
        $downloadType = array(0 => 'Qua Store', 1 => 'Tải file');
        return view('admin.others.linkDownload.edit',compact('linkDownload','osBuild', 'downloadType'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'os' => 'required',
            'link_tai' => 'required',
            'file_down' => 'required',
            'is_direct' => 'required',
            'status' => 'required',
            'file_down' => 'required|mimes:apk,ipa,exe',
            'delay' => 'required'
        ]);

        $giftEvent = TaiGame::find($id);
        $giftEvent->os = $request->input('os');
        $giftEvent->link_tai = $request->input('link_tai');
        $giftEvent->is_direct = $request->input('is_direct');
        $giftEvent->delay = $request->input('delay');
        $giftEvent->status = $request->input('status');
        $giftEvent->file_down = $request->input('file_down');
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
