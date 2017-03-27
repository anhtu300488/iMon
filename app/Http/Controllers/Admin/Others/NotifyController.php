<?php

namespace App\Http\Controllers\Admin\Others;

use App\Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifyController extends Controller
{
    public function index(Request $request){

        $content = \Request::get('content');
        $status = \Request::get('status');

        $query = Notify::query();
        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }
        $query->where($matchThese);

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.others.notify.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        return view('admin.others.notify.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'content' => 'required',
        ]);


        $input = $request->all();
        $input['status'] = 1;
        Notify::create($input);

        return redirect()->route('notify.index')
            ->with('success','Add Notify successfully');
    }

    public function edit($id){
        $notify = Notify::find($id);

        return view('admin.others.notify.edit',compact('notify'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'content' => 'required',
        ]);

        $notify = Notify::find($id);
        $notify->content = $request->input('content');
        $notify->status = 1;
        $notify->save();

        return redirect()->route('notify.index')
            ->with('success','Notify updated successfully');
    }

    public function destroy($id){
        Notify::find($id)->delete();
        return redirect()->route('notify.index')
            ->with('success','Notify deleted successfully');
    }
}
