<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SendEmailController extends Controller
{
    public function create(){
        return view('admin.tool.sendEmail.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'recipientUserName' => 'required',
            'title' => 'required',
            'body' => 'required'
        ]);
        $input = $request->all();
        $input['senderUserId'] = -1;
        $input['senderUserName'] = 'Hệ thống';
        $input['recipientUserId'] = 1000001;
        Message::create($input);
        return view('admin.tool.sendEmail.create');
    }
}
