<?php

namespace App\Http\Controllers\Admin\Users;

use App\ClientType;
use App\LoggedInLog;
use App\Partner;
use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $device = \Request::get('device');
        $os = \Request::get('clientType');
        $ip = \Request::get('ip');

        $partner = Partner::pluck('partnerName', 'partnerId');

        $partner->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $matchThese = [];
        if($os != ''){
            $matchThese['clientId'] = $os;
        }

        $query = UserReg::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($device != ''){
            $query->where('device','LIKE','%'.$device.'%');
        }

        if($ip != ''){
            $query->where('ip','LIKE','%'.$ip.'%');
        }

        $query->where($matchThese);

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('registedTime',[$start,$end]);
        }
        $data = $query->orderBy('registedTime', 'desc')->paginate(10);

        $total_by_os = UserReg::getTotalUserByOs();

        $day = 60*60*24; $day_7 = time() - 6*$day;
        $register_info = UserReg::getRegisterInfo(date("Y-m-d", $day_7) . "00:00:00");
        $register_info_new = UserReg::getRegisterInfoNew(date("Y-m-d", $day_7) . "00:00:00");
        $user_play_inday  =  UserReg::getPlayUserInday(date("Y-m-d", $day_7) . "00:00:00");
        $user_login_inday = LoggedInLog::getPlayUserInday(date("Y-m-d", $day_7) . "00:00:00");
//        $register_info_new = UserTable::getRegisterInfoNew(date("Y-m-d", $day_7) . "00:00:00");
        $created_at = array();
        //tai khoan moi
        foreach($register_info as $date){
//            var_dump($date->date);die;
            $created_at[$date->date] = $date->count;
        }
        // thiet bị moi
        $created_at_new = array();

        foreach($register_info_new as $date){
            $created_at_new[$date->date] = $date->count;
        }
        // nguoi choi hang ngay
        $play_in_day= array();

        foreach($user_play_inday as $date){
            $play_in_day[$date->date] = $date->count;
        }
        // nguoi choi trong ngay
        $login_in_day= array();
        foreach($user_login_inday as $date){
            $login_in_day[$date->date] = $date->count;
        }
        $sevent_day = array();

        for($i=0; $i<7; $i++) {
            $sevent_day[date("d/m/Y", $day_7 + $i* $day)] = array(
                isset($created_at[date("Y-m-d", $day_7 + $i* $day)]) ? $created_at[date("Y-m-d", $day_7 + $i* $day)]: 0,
                isset($created_at_new[date("Y-m-d", $day_7 + $i* $day)]) ? $created_at_new[date("Y-m-d", $day_7 + $i* $day)]: 0,
                isset($play_in_day[date("Y-m-d", $day_7 + $i* $day)]) ? $play_in_day[date("Y-m-d", $day_7 + $i* $day)]: 0,
                isset($login_in_day[date("Y-m-d", $day_7 + $i* $day)]) ? $login_in_day[date("Y-m-d", $day_7 + $i* $day)]: 0,
            );

        }

        return view('admin.users.userReg.index',compact('data', 'partner', 'clientType', 'total_by_os', 'sevent_day'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
