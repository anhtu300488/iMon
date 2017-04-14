<?php

namespace App\Http\Controllers\Admin\Users;

use App\ClientType;
use App\LoggedInLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRateActiveController extends Controller
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

//        var_dump($loginTime);die;

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

        $total3Rs = LoggedInLog::getTotalActive3R($userID, $userName, $ime, $ip, $client, $loginTime);
        $total5Rs = LoggedInLog::getTotalActive5R($userID, $userName, $ime, $ip, $client, $loginTime);
        $total7Rs = LoggedInLog::getTotalActive7R($userID, $userName, $ime, $ip, $client, $loginTime);
        $total30Rs = LoggedInLog::getTotalActive30R($userID, $userName, $ime, $ip, $client, $loginTime);

//        var_dump($total5Rs);die;

//        $totals = LoggedInLog::getTotalUser($userID, $userName, $ime, $ip, $client, $loginTime);

        $login_arr = array();

        foreach ($total3Rs as $index => $total){
            $login_arr[$total->purchase_date][0] = isset($total->total) ? $total->total : 0;
        }

        foreach ($total5Rs as $index => $total){
            $login_arr[$total->purchase_date][1] = isset($total->total) ? $total->total : 0;
        }

        foreach ($total7Rs as $index => $total){
            $login_arr[$total->purchase_date][2] = isset($total->total) ? $total->total : 0;
        }

        foreach ($total30Rs as $index => $total){
            $login_arr[$total->purchase_date][3] = isset($total->total) ? $total->total : 0;
        }

        return view('admin.users.userRateActive.index',compact('data', 'clientType', 'login_arr'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
