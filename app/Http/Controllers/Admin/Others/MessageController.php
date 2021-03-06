<?php

namespace App\Http\Controllers\Admin\Others;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class MessageController extends Controller
{
    public function index(Request $request){

        $senderUserId = \Request::get('senderUserId');
        $senderUsername = \Request::get('senderUsername');
        $recipientUserId = \Request::get('recipientUserId');
        $recipientUsername = \Request::get('recipientUsername');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = Message::query();
        if($senderUserId != ''){
            $query->where('senderUserId','LIKE','%'.$senderUserId.'%');
        }

        if($senderUsername != ''){
            $query->where('senderUsername','LIKE','%'.$senderUsername.'%');
        }

        if($recipientUserId != ''){
            $query->where('recipientUserId','LIKE','%'.$recipientUserId.'%');
        }

        if($recipientUsername != ''){
            $query->where('recipientUsername','LIKE','%'.$recipientUsername.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('messageId','asc')->offset($startLimit)->limit($perPage)->paginate($perPage);

//        var_dump($data);die;

        return view('admin.others.messageUser.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

}
