<?php

namespace App\Http\Controllers\Admin\Tool;

use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhoneUpdateController extends Controller
{
    public function phone(){
        return view('admin.tool.users.phoneUpdate');
    }

    public function store(Request $request){
        $this->validate($request, [
            'userName' => 'required',
            'mobile' => 'required'
        ]);

        //update user table
        UserReg::where('userName', $request->get('userName'))
            ->update(['mobile' => $request->get('mobile')]);

        return redirect()->route('tool.phoneUpdate')
            ->with('message','Phone email successfully');
    }
}
