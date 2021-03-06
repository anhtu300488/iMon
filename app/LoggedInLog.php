<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoggedInLog extends Model
{
    protected $table = 'logged_in_log';

    public static function getPlayUserInday($created_at, $cp)
    {
        $query = DB::table('logged_in_log as a')
            ->select (DB::raw('count(DISTINCT a.userId) count'), DB::raw('date(a.loggedInTime) date'));
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'a.userId');

        });
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        return $query->groupBy(DB::raw('date(a.loggedInTime)'))
            ->where("a.loggedInTime",">", $created_at)
            ->get()->toArray();
    }

    public static function getTotalUser($userID, $userName, $ime, $ip, $client, $loginTime)
    {

//        var_dump($userID);die;
        $query = DB::table('logged_in_log');
        $query->select(DB::raw('COUNT(DISTINCT userId) as total'), DB::raw("DATE(loggedInTime) purchase_date"));

        if ($loginTime) {
            $startDateCharge = $loginTime[0];

            $endDateCharge = $loginTime[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('loggedInTime',[$start,$end]);
            }
        } else {
            $query->where("loggedInTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }
//        if($userID){
//            $query->where('userId ','=',$userID);
//        }
        if($client){
            $query->where('clientType','=',$client);
        }

        if($userName){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($ime){
            $query->where('deviceId','LIKE','%'.$ime.'%');
        }

        if($ip){
            $query->where('remoteIp','LIKE','%'.$ip.'%');
        }

        $query->groupBy(DB::raw("DATE(loggedInTime)"));
        return $query->get()->toArray();
    }

    public static function getTotalActive1R($loginTime)
    {


        $query = DB::table('logged_in_log as p');
        $query->select(DB::raw('COUNT(DISTINCT p.userId) as total'), DB::raw("DATE(p.loggedInTime) purchase_date"));
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if ($loginTime) {
            $startDateCharge = date("Y-m-d",strtotime($loginTime[0]));
            $endDateCharge = date("Y-m-d",strtotime($loginTime[1]));

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge) );
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge) );
                if($start >= date("Y-m-d 00:00:00",strtotime(Carbon::now()) )){
                    $start = date("Y-m-d 00:00:00",strtotime(Carbon::now()) );
                }

                if($end >= date("Y-m-d 23:59:59",strtotime(Carbon::now()) )){
                    $end = date("Y-m-d 23:59:59",strtotime(Carbon::now()) );
                }
                $query->whereBetween('p.loggedInTime',[$start,$end]);
                $query->whereDate('user.registedTime', '=', $startDateCharge);
            }
        }
//        else {
//            $query->where("p.loggedInTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
//            $query->whereDate('user.registedTime', '=', Date("Y-m-d", time() - 86400* 7));
//        }

        $query->groupBy(DB::raw("DATE(p.loggedInTime)"));
        return $query->get()->toArray();
    }

    public static function getTotalActive3R($loginTime)
    {
        $query = DB::table('logged_in_log as p');
        $query->select(DB::raw('COUNT(DISTINCT p.userId) as total'), DB::raw("DATE(p.loggedInTime) purchase_date"));
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if ($loginTime) {
            $startDateCharge = date("Y-m-d",strtotime($loginTime[0]));
            $endDateCharge = date("Y-m-d",strtotime($loginTime[1]));

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge.' +3 days') );
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge.' +3 days') );
                if($start >= date("Y-m-d 00:00:00",strtotime(Carbon::now()) )){
                    $start = date("Y-m-d 00:00:00",strtotime(Carbon::now()) );
                }

                if($end >= date("Y-m-d 23:59:59",strtotime(Carbon::now()) )){
                    $end = date("Y-m-d 23:59:59",strtotime(Carbon::now()) );
                }
                $query->whereBetween('p.loggedInTime',[$start,$end]);
                $query->whereDate('user.registedTime', '=', $startDateCharge);
            }
        }
//        else {
//            $query->where("p.loggedInTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
//            $query->whereDate('user.registedTime', '=', Date("Y-m-d", time() - 86400* 7));
//        }

        $query->groupBy(DB::raw("DATE(p.loggedInTime)"));
        return $query->get()->toArray();
    }

    public static function getTotalActive5R($loginTime)
    {


        $query = DB::table('logged_in_log as p');
        $query->select(DB::raw('COUNT(DISTINCT p.userId) as total'), DB::raw("DATE(p.loggedInTime) purchase_date"));
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if ($loginTime) {
            $startDateCharge = date("Y-m-d",strtotime($loginTime[0]));
            $endDateCharge = date("Y-m-d",strtotime($loginTime[1]));

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge.' +5 days') );
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge.' +5 days') );
                if($start >= date("Y-m-d 00:00:00",strtotime(Carbon::now()) )){
                    $start = date("Y-m-d 00:00:00",strtotime(Carbon::now()) );
                }

                if($end >= date("Y-m-d 23:59:59",strtotime(Carbon::now()) )){
                    $end = date("Y-m-d 23:59:59",strtotime(Carbon::now()) );
                }
                $query->whereBetween('p.loggedInTime',[$start,$end]);
                $query->whereDate('user.registedTime', '=', $startDateCharge);
            }
        }
//        else {
//            $query->where("p.loggedInTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
//            $query->whereDate('user.registedTime', '=', Date("Y-m-d", time() - 86400* 7));
//        }

        $query->groupBy(DB::raw("DATE(p.loggedInTime)"));
        return $query->get()->toArray();
    }

    public static function getTotalActive7R($loginTime)
    {


        $query = DB::table('logged_in_log as p');
        $query->select(DB::raw('COUNT(DISTINCT p.userId) as total'), DB::raw("DATE(p.loggedInTime) purchase_date"));
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if ($loginTime) {
            $startDateCharge = date("Y-m-d",strtotime($loginTime[0]));
            $endDateCharge = date("Y-m-d",strtotime($loginTime[1]));

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge.' +7 days') );
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge.' +7 days') );
                if($start >= date("Y-m-d 00:00:00",strtotime(Carbon::now()) )){
                    $start = date("Y-m-d 00:00:00",strtotime(Carbon::now()) );
                }

                if($end >= date("Y-m-d 23:59:59",strtotime(Carbon::now()) )){
                    $end = date("Y-m-d 23:59:59",strtotime(Carbon::now()) );
                }
                $query->whereBetween('p.loggedInTime',[$start,$end]);
                $query->whereDate('user.registedTime', '=', $startDateCharge);
            }
        }
//        else {
//            $query->where("p.loggedInTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
//            $query->whereDate('user.registedTime', '=', Date("Y-m-d", time() - 86400* 7));
//        }

        $query->groupBy(DB::raw("DATE(p.loggedInTime)"));
        return $query->get()->toArray();
    }

    public static function getTotalActive30R($loginTime)
    {


        $query = DB::table('logged_in_log as p');
        $query->select(DB::raw('COUNT(DISTINCT p.userId) as total'), DB::raw("DATE(p.loggedInTime) purchase_date"));
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if ($loginTime) {
            $startDateCharge = date("Y-m-d",strtotime($loginTime[0]));
            $endDateCharge = date("Y-m-d",strtotime($loginTime[1]));

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge.' +30 days') );
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge.' +30 days') );
                if($start >= date("Y-m-d 00:00:00",strtotime(Carbon::now()) )){
                    $start = date("Y-m-d 00:00:00",strtotime(Carbon::now()) );
                }

                if($end >= date("Y-m-d 23:59:59",strtotime(Carbon::now()) )){
                    $end = date("Y-m-d 23:59:59",strtotime(Carbon::now()) );
                }
                $query->whereBetween('p.loggedInTime',[$start,$end]);
                $query->whereDate('user.registedTime', '=', $startDateCharge);
            }
        }
//        else {
//            $query->where("p.loggedInTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
//            $query->whereDate('user.registedTime', '=', Date("Y-m-d", time() - 86400* 7));
//        }

        $query->groupBy(DB::raw("DATE(p.loggedInTime)"));
        return $query->get()->toArray();
    }
}
