<?php

namespace App\Http\Controllers\Admin\Others;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index(Request $request){

        $senderUserId = \Request::get('senderUserId');
        $senderUsername = \Request::get('senderUsername');
        $recipientUserId = \Request::get('recipientUserId');
        $recipientUsername = \Request::get('recipientUsername');

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

        $data = $query->orderBy('messageId','asc')->paginate(10);

//        var_dump($data);die;

        return view('admin.others.messageUser.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

}
