<?php

namespace App\Http\Controllers\Admin\Users;

use App\UserOTP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userID = \Request::get('userID');
        $phone = \Request::get('phone');
        $verifyCode = \Request::get('verifyCode');
        $status = \Request::get('status');
        $type = \Request::get('type');

        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        if($type != ''){
            $matchThese['type'] = $type;
        }

        if($userID != ''){
            $matchThese['userId'] = $userID;
        }

        $query = UserOTP::query();

        if($phone != ''){
            $query->where('device','LIKE','%'.$phone.'%');
        }

        if($verifyCode != ''){
            $query->where('ip','LIKE','%'.$verifyCode.'%');
        }

        $query->where($matchThese);

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.otp.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
