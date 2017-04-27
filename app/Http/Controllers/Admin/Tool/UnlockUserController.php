<?php

namespace App\Http\Controllers\Admin\Tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UnlockUserController extends Controller
{
    public function unlock(){
        return view('admin.tool.users.unlock');
    }

    public function store(Request $request){
        $this->validate($request, [
            'userName' => 'required'
        ]);

//        var_dump($request->get('userName'));die;

        //update user table
        DB::table('user')
            ->where('userName', $request->get('userName'))
            ->update(['status' => 1]);

        return redirect()->route('tool.unlockUser')
            ->with('message','Unlock user successfully');
    }
}
