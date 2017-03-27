<?php

namespace App\Http\Controllers\Admin\Users;

use App\LoggedInLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogUserLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userID = \Request::get('userID');
        $userName = \Request::get('userName');
        $ime = \Request::get('ime');
        $ip = \Request::get('ip');

        $matchThese = [];
        if($userID != ''){
            $matchThese['userId'] = $userID;
        }

        $query = LoggedInLog::query();

        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($ime != ''){
            $query->where('deviceId','LIKE','%'.$ime.'%');
        }

        if($ip != ''){
            $query->where('remoteIp','LIKE','%'.$ip.'%');
        }

        $query->where($matchThese);

        $data = $query->orderBy('loggedInTime', 'desc')->paginate(10);

        return view('admin.users.logUserLogin.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
