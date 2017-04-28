<?php

namespace App\Http\Controllers\Admin\Others;

use App\Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class NotifyController extends Controller
{
    public function index(Request $request){

        $content = \Request::get('content');
        $status = \Request::get('status');

        $statusArr = array('' => '---Tất cả---', 0 => 'Active', 1 => 'Deactive');

        $query = Notify::query();
        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.others.notify.index',compact('data', 'statusArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.others.notify.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'content' => 'required|max:40000',
        ]);


        $input = $request->all();
        $input['status'] = 1;
        Notify::create($input);

        return redirect()->route('notify.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $notify = Notify::find($id);

        return view('admin.others.notify.edit',compact('notify'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'content' => 'required|max:40000',
        ]);

        $notify = Notify::find($id);
        $notify->content = $request->input('content');
        $notify->status = 1;
        $notify->save();

        return redirect()->route('notify.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        Notify::find($id)->delete();
        return redirect()->route('notify.index')
            ->with('message','Deleted Successfully');
    }
}
