<?php

namespace App\Http\Controllers\Admin\System;

use App\IpLock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LockIpController extends Controller
{
    public function index(){
        return view('admin.system.ipLock.index');
    }

    public function store(Request $request){
        $this->validate($request, [
            'ip' => 'required'
        ]);

        //insert into blacklist user
        $ipLock = new IpLock;
        $ipLock->ip = $request->get('ip');
        $ipLock->userAdminId = Auth::user()->id;

        $ipLock->save();

        return redirect()->route('system.ipLock')
            ->with('message','Lock IP Successfully');
    }
}
