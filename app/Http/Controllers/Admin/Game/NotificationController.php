<?php

namespace App\Http\Controllers\Admin\Game;

use App\EmergencyNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $query = EmergencyNotification::query();

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }

        $data = $query->orderBy('createdTime', 'desc')->paginate(10);

        return view('admin.game.notification.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        return view('admin.game.notification.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'content' => 'required|max:1000'
        ]);


        $notification = new EmergencyNotification;

        $notification->content = $request->get('content');
        $notification->save();

        return redirect()->route('notification.index')
            ->with('success','Add message successfully');
    }

    public function edit($id){
//        $notification = EmergencyNotification::query()->where("notificationId",$id)->first();
        $notification = EmergencyNotification::find($id);

//        var_dump($notification);die;

        return view('admin.game.notification.edit',compact('role','notification'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'content' => 'required|max:1000'
        ]);

        $notification = EmergencyNotification::find($id);
        $notification->content = $request->input('content');
        $notification->save();

        return redirect()->route('notification.index')
            ->with('success','Message updated successfully');
    }

    public function destroy($id){
        EmergencyNotification::query()->where('notificationId',$id)->delete();
        return redirect()->route('notification.index')
            ->with('success','Message deleted successfully');
    }
}
