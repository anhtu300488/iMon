<?php

namespace App\Http\Controllers\Admin\Tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServerMessageController extends Controller
{
    public function index(Request $request){
        return view('admin.tool.serverMessage.index');
    }
    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
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
        return view('admin.tool.serverMessage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'userId' => 'required|integer',
//            'addGold' => 'required|integer',
//            'addCash' => 'required|integer'
//        ]);
//
//        $addMoney = new AddMoney;
//
//        $addMoney->userId = $request->get('userId');
//        $addMoney->addGold = $request->get('addGold');
//        $addMoney->addCash = $request->get('addCash');
//        $addMoney->description = $request->get('description');
//        $addMoney->admin_id = Auth::user()->id;
//        $addMoney->status = 1;
//        $addMoney->created_at = Carbon::now();
//        $addMoney->updated_at = Carbon::now();
//        $addMoney->save();

        return redirect()->route('tool.serverMessage')
            ->with('message','Add message successfully');
    }
}
