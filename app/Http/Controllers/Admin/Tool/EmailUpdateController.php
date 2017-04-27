<?php

namespace App\Http\Controllers\Admin\Tool;

use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailUpdateController extends Controller
{
    public function email(){
        return view('admin.tool.users.emailUpdate');
    }

    public function store(Request $request){
        $this->validate($request, [
            'userName' => 'required',
            'email' => 'required|email'
        ]);

        //update user table
        UserReg::where('userName', $request->get('userName'))
            ->update(['email' => $request->get('email')]);

        return redirect()->route('tool.emailUpdate')
            ->with('message','Update Successfully');
    }
}
