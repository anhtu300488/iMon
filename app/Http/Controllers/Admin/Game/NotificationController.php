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

        $query = EmergencyNotification::query();

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('createdTime', 'desc')->paginate($perPage);

        return view('admin.game.notification.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
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
            ->with('message','Add Successfully');
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
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        EmergencyNotification::query()->where('notificationId',$id)->delete();
        return redirect()->route('notification.index')
            ->with('message','Deleted Successfully');
    }
}
