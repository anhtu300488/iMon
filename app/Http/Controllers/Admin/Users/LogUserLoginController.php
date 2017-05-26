<?php

namespace App\Http\Controllers\Admin\Users;

use App\ClientType;
use App\LoggedInLog;
use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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
        $loginTime = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : getToday();
        $page = \Request::get('page') ? \Request::get('page') : 1;

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
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('loggedInTime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        $totals = LoggedInLog::getTotalUser($userID, $userName, $ime, $ip, $client, $loginTime);

        $login_arr = array();

        foreach ($totals as $index => $total){
            $login_arr[$total->purchase_date] = isset($total->total) ? $total->total : 0;
        }

        return view('admin.users.logUserLogin.index',compact('data', 'clientType', 'login_arr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function downloadExcel(Request $request){

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

        $query = LoggedInLog::query()->select("userId","userName", "loggedInTime", "deviceId", "deviceInfo", "remoteIp", "clientType", "packageName", "versionCode", "versionBuild");

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

        $results = $query->orderBy('loggedInTime', 'desc')->get();

        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = $result->toArray();
            $data[$k]["clientType"] = $clientType[$result->clientType];

        }
        // Generate and return the spreadsheet

        return \Maatwebsite\Excel\Facades\Excel::create('log_user_login', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $headings = array('User ID', 'Tên đăng nhập','Logged in time','IME','Thông tin thiết bị', 'Địa chỉ Ip', 'Client type', 'Package name', 'Version code', 'Version build');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }
}
