<?php

namespace App\Http\Controllers\Admin\Others;

use App\Emoji;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class NotificationController extends Controller
{
    public function index(Request $request){

        $title = \Request::get('title');
        $message = \Request::get('message');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = Notification::query();
        if($title != ''){
            $query->where('title','LIKE','%'.$title.'%');
        }

        if($message != ''){
            $query->where('message','LIKE','%'.$message.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('notificationId', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.others.notification.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.others.notification.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|max:100',
            'message' => 'required|max:200',
            'pushTime' => 'required',
        ]);
        $input = $request->all();
        $input['admin_id'] = Auth::user()->id;
        $time = explode(":",$request->get('pushTime'));
        $input['pushHour'] = $time[0];
        $input['pushMinutes'] = $time[1];
        $input['message'] = Emoji::Encode($request->get('message'));
        Notification::create($input);

        return redirect()->route('notification.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $notification = Notification::find($id);
        $notification->message = Emoji::Decode($notification->message);
        return view('admin.others.notification.edit',compact('notification'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required|max:100',
            'message' => 'required|max:200',
            'pushTime' => 'required',
        ]);

        $giftEvent = Notification::find($id);
        $time = explode(":",$request->get('pushTime'));
        $giftEvent->title = $request->input('title');
        $giftEvent->message = Emoji::Encode($request->get('message'));
        $giftEvent->pushTime = $request->input('pushTime');
        $giftEvent->pushHour = $time[0];
        $giftEvent->pushMinutes = $time[1];
        $giftEvent->repeat_daily = $request->input('repeat_daily');
        $giftEvent->status = $request->input('status');
        $giftEvent->admin_id = Auth::user()->id;
        $giftEvent->save();

        return redirect()->route('notification.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        Notification::find($id)->delete();
        return redirect()->route('notification.index')
            ->with('message','Deleted Successfully');
    }
}
