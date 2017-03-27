<?php

namespace App\Http\Controllers\Admin\Tool;

use App\BlackListUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LockUserController extends Controller
{
    public function lock(){
        return view('admin.tool.users.lock');
    }

    public function store(Request $request){
        $this->validate($request, [
            'userName' => 'required'
        ]);

        $userId = DB::table('user')->select(DB::raw('userId'))->where('userName', '=', $request->get('userName'))->first();

        //insert into blacklist user
        $blackListUser = new BlackListUser;
        $blackListUser->userId = $userId->userId;
        $blackListUser->userLockId = Auth::user()->id;
        $blackListUser->lockType = 2;

        $blackListUser->save();

        return redirect()->route('tool.lockUser')
            ->with('success','Lock user successfully');
    }
}
