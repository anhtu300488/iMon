<?php

namespace App\Http\Controllers\Admin\Game;

use App\EmergencyNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $content = \Request::get('content');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = EmergencyNotification::query();

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('createdTime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.game.notification.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.game.notification.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'content' => 'required|max:1000',
            'fromDate' => 'required',
            'fromTime' => 'required',
            'toDate' => 'required',
            'toTime' => 'required'
        ]);

        $fromDate = $request->get('fromDate');
        $fromTime = $request->get('fromTime');
        $toDate = $request->get('toDate');
        $toTime = $request->get('toTime');

        $createdTime = date("Y-m-d", strtotime($fromDate)) . ' ' . $fromTime;

        $expriedTime = date("Y-m-d", strtotime($toDate)) . ' ' . $toTime;

        $notification = new EmergencyNotification;

        $notification->content = $request->get('content');
        $notification->createdTime = $createdTime;
        $notification->expriedTime = $expriedTime;
        $notification->active = $request->get('active');
        $notification->save();

        return redirect()->route('emergencyNotification.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $notification = EmergencyNotification::find($id);
        $createdTime = $notification->createdTime;
        $expriedTime = $notification->expriedTime;
        $from = explode(' ', $createdTime);
        $to = explode(' ', $expriedTime);
        $fromDate = $from[0];
        $fromTime = $from[1];
        $toDate = $to[0];
        $toTime = $to[1];
        $notification->fromDate = $fromDate;
        $notification->fromTime = $fromTime;
        $notification->toDate = $toDate;
        $notification->toTime = $toTime;
        return view('admin.game.notification.edit',compact('role','notification'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'content' => 'required|max:1000',
            'fromDate' => 'required',
            'fromTime' => 'required',
            'toDate' => 'required',
            'toTime' => 'required'
        ]);
        $fromDate = $request->get('fromDate');
        $fromTime = $request->get('fromTime');
        $toDate = $request->get('toDate');
        $toTime = $request->get('toTime');

        $createdTime = date("Y-m-d", strtotime($fromDate)) . ' ' . $fromTime;

        $expriedTime = date("Y-m-d", strtotime($toDate)) . ' ' . $toTime;

        $notification = EmergencyNotification::find($id);
        $notification->content = $request->input('content');
        $notification->createdTime = $createdTime;
        $notification->expriedTime = $expriedTime;
        $notification->active = $request->get('active');
        $notification->save();

        return redirect()->route('emergencyNotification.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        EmergencyNotification::query()->where('notificationId',$id)->delete();
        return redirect()->route('emergencyNotification.index')
            ->with('message','Deleted Successfully');
    }
}
