<?php

namespace App\Http\Controllers\Admin\Users;

use App\UserOtpAuto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class OtpAutoController extends Controller
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
        $status = \Request::get('status');

        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        if($userID != ''){
            $matchThese['userId'] = $userID;
        }

        $query = UserOtpAuto::query();

        if($phone != ''){
            $query->where('device','LIKE','%'.$phone.'%');
        }

        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.users.otpAuto.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
