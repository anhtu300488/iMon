<?php

namespace App\Http\Controllers\Admin\Others;

use App\LogWeb;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{
    public function index(Request $request){
        $senderId = \Request::get('senderUserId');
        $senderName = \Request::get('senderUserName');
        $title = \Request::get('title');
        $body = \Request::get('body');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = Message::query();
        if($senderId != ''){
            $query->where('senderUserId',$senderId);
        }

        if($senderName != ''){
            $query->where('senderUserName','LIKE','%'.$senderName.'%');
        }

        if($title != ''){
            $query->where('title','LIKE','%'.$title.'%');
        }

        if($body != ''){
            $query->where('body','LIKE','%'.$body.'%');
        }

        $query->where('recipientUserId',1000000)->where('status',1) ->whereNull('parentId');

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $data = $query->orderBy('messageId', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.others.mail.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function show($id){
        Message::where('messageId', $id)
            ->update(['readed' => 1]);
        $data = Message::find($id);
        return view('admin.others.mail.show',compact('data'));
    }

    public function store(Request $request){
        $input = $request->all();
        Message::create($input);

        return redirect()->back();
    }

    public function destroy($id){
        Message::where('messageId', $id)
            ->update(['status' => 0]);
        return redirect()->back();
    }
}
