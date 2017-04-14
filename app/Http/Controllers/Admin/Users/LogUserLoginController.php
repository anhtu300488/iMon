<?php

namespace App\Http\Controllers\Admin\Users;

use App\ClientType;
use App\LoggedInLog;
use App\UserReg;
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
        $client = \Request::get('clientType');
        $loginTime = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $matchThese = [];
        if($userID != ''){
            $matchThese['userId'] = $userID;
        }

        if($client != ''){
            $matchThese['clientType'] = $client;
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

        if($loginTime != ''){
            $startDateCharge = $loginTime[0];

            $endDateCharge = $loginTime[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('loggedInTime',[$start,$end]);
            }
        } else {
            $query->where("loggedInTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
        }

        $query->where($matchThese);

        $data = $query->orderBy('loggedInTime', 'desc')->paginate(10);

        $totals = LoggedInLog::getTotalUser($userID, $userName, $ime, $ip, $client, $loginTime);

        $login_arr = array();

        foreach ($totals as $index => $total){
            $login_arr[$total->purchase_date] = isset($total->total) ? $total->total : 0;
        }

        return view('admin.users.logUserLogin.index',compact('data', 'clientType', 'login_arr'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
