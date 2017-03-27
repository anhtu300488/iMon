<?php

namespace App\Http\Controllers\Admin\Others;

use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request){

        $title = \Request::get('title');
        $message = \Request::get('message');

        $query = Notification::query();
        if($title != ''){
            $query->where('title','LIKE','%'.$title.'%');
        }

        if($message != ''){
            $query->where('message','LIKE','%'.$message.'%');
        }
        $data = $query->orderBy('notificationId', 'desc')->paginate(10);

        return view('admin.others.notification.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        return view('admin.others.notification.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required',
            'pushHour' => 'required',
            'pushMinutes' => 'required',
            'repeat_daily' => 'required',
            'status' => 'required'
        ]);


        $input = $request->all();
        $input['admin_id'] = Auth::user()->id;
        Notification::create($input);

        return redirect()->route('notification.index')
            ->with('success','Add notification successfully');
    }

    public function edit($id){
        $notification = Notification::find($id);

        return view('admin.others.notification.edit',compact('notification'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required',
            'pushHour' => 'required',
            'pushMinutes' => 'required',
            'repeat_daily' => 'required',
            'status' => 'required'
        ]);

        $giftEvent = Notification::find($id);
        $giftEvent->title = $request->input('title');
        $giftEvent->message = $request->input('message');
        $giftEvent->pushHour = $request->input('pushHour');
        $giftEvent->pushMinutes = $request->get('pushMinutes');
        $giftEvent->repeat_daily = $request->input('repeat_daily');
        $giftEvent->status = $request->input('status');
        $giftEvent->admin_id = Auth::user()->id;
        $giftEvent->save();

        return redirect()->route('notification.index')
            ->with('success','Gift Event updated successfully');
    }

    public function destroy($id){
        Notification::find($id)->delete();
        return redirect()->route('notification.index')
            ->with('success','Gift Event deleted successfully');
    }
}
