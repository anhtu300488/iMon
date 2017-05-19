<?php

namespace App\Http\Controllers\Admin\Users;

use App\UserOTP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $typeArr = array('' => '---Tất cả---', 0 => 'Xác thực', 1 => 'Reset mật khẩu', 2 => 'Hủy xác thực');

        $statusArr = array('' => '---Tất cả---', 0 => 'Chửa sử dụng', 1 => 'Đã sử dụng');

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
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

//        var_dump($data);die;

        return view('admin.users.otp.index',compact('data', 'typeArr', 'statusArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
