<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class PurchaseMoneyLog extends Model
{
    protected $table = 'purchase_money_log';

    public function users()
    {
        return $this->belongsToMany('App\UserReg', 'user','userId');
    }
    public static function getSumRevenuShare($dateCharge, $cp)
    {
        $query = DB::table('purchase_money_log as p');
        $query->select(DB::raw('SUM(p.parValue) as sum_money'));
        $query->where(DB::raw('p.description'),'!=', "GameOperator");

        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }

        $query->where(DB::raw('p.type'),'=', 1);
        return $query->get()->toArray();
    }
    public static function getTotalByType($type, $userName, $dateCharge, $datePlayGame, $cp, $os)
    {
        $query = DB::table('purchase_money_log as p');
        $query->select(DB::raw('p.type as type'),  DB::raw('SUM(p.parValue) as sum_money') , DB::raw('SUM(p.cashValue) as sum_cash') );
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        } else {
            $query->where("p.purchasedTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days') ));
        }

        if($datePlayGame != ''){
            $startPlayGame = $datePlayGame[0];

            $endPlayGame = $datePlayGame[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
            }
        }
        if($type != null){
            $query->where(DB::raw('p.type'),'=', $type);
        }
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        if($os != null){
            $query->where(DB::raw('user.clientId'),'=', $os);
        }
        if($userName != null){
            $query->where('p.userName','LIKE','%'.$userName.'%');
        }

         $query->groupBy("p.type");
        return $query->get()->toArray();
    }
    public static function getTotalRevenueByDate($type, $userName, $dateCharge, $datePlayGame, $cp, $os)
    {
        $search = false;

        $query = DB::table('purchase_money_log as p');
        $inday = 0;

        if($dateCharge != '' && $dateCharge[0] == $dateCharge[1]){
            $query->select(DB::raw("HOUR(p.purchasedTime) purchase_date"), 'p.type as type',  DB::raw('SUM(p.parValue) as sum_money') , DB::raw('SUM(p.cashValue)/10 as sum_cash') );
            $inday = 1;
            $search = true;
        } else {
            $query->select(DB::raw("DATE(p.purchasedTime) purchase_date"), 'p.type as type',  DB::raw('SUM(p.parValue) as sum_money') , DB::raw('SUM(p.cashValue)/10 as sum_cash') );
        };

        $query->join('user', function($join)
            {
                $join->on('user.userId', '=', 'p.userId');

            });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($type != null){
            $query->where(DB::raw('p.type'),'=', $type);
        }
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        if($os != null){
            $query->where(DB::raw('user.clientId'),'=', $os);
        }
        if($userName != null){
            $query->where('p.userName','LIKE','%'.$userName.'%');
        }
        if($dateCharge != ''){
            $search = true;

            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }

        if($datePlayGame != ''){
            $startPlayGame = $datePlayGame[0];

            $endPlayGame = $datePlayGame[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
            }
        }

        if(!$search){
            $query->where("p.purchasedTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }

        if($inday == 1){
            $query->groupBy(DB::raw("HOUR(p.purchasedTime)"), 'p.type');
        } else {
            $query->groupBy(DB::raw("DATE(p.purchasedTime)"), 'p.type');
        }

        $data = $query->get()->toArray();


        return $data;
    }

    public static function getTotalUserByType($type, $userName, $dateCharge, $datePlayGame, $cp, $os)
    {
        $query = DB::table('purchase_money_log as p');
        $query->select("p.type", DB::raw('COUNT(DISTINCT p.userId) as total'));

        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }

        if($datePlayGame != ''){
            $startPlayGame = $datePlayGame[0];

            $endPlayGame = $datePlayGame[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
            }
        }
        if($type != null){
            $query->where(DB::raw('p.type'),'=', $type);
        }
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        if($os != null){
            $query->where(DB::raw('user.clientId'),'=', $os);
        }
        if($userName != null){
            $query->where('p.userName','LIKE','%'.$userName.'%');
        }

        $query->groupBy("p.type");
        return $query->get()->toArray();
    }

    public static function getTotalUserRevenueByDate($type, $userName, $dateCharge, $datePlayGame, $cp, $os)
    {
        $search = false;

        $query = DB::table('purchase_money_log as p');
        $inday = 0;
        if($dateCharge != '' && $dateCharge[0] == $dateCharge[1]){
            $query->select(DB::raw("HOUR(p.purchasedTime) purchase_date"), 'p.type as type',  DB::raw('COUNT( DISTINCT p.userId) as total') );
            $inday = 1;
            $search = true;
        } else {
            $query->select(DB::raw("DATE(p.purchasedTime) purchase_date"), 'p.type as type',  DB::raw('COUNT( DISTINCT p.userId) as total') );
        };

        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($type != null){
            $query->where(DB::raw('p.type'),'=', $type);
        }
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        if($os != null){
            $query->where(DB::raw('user.clientId'),'=', $os);
        }
        if($userName != null){
            $query->where('p.userName','LIKE','%'.$userName.'%');
        }
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }

        if($datePlayGame != ''){
            $startPlayGame = $datePlayGame[0];

            $endPlayGame = $datePlayGame[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
            }
        }

        if(!$search){
            $query->where("p.purchasedTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }

        if($inday == 1){
            $query->groupBy(DB::raw("HOUR(purchasedTime)"), 'type');
        } else {
            $query->groupBy(DB::raw("DATE(p.purchasedTime)"), 'type');
        }

        $data = $query->get()->toArray();


        return $data;
    }

    public static function getTotalRevenueUserActive($dateCharge, $cp = null)
    {
        $search = false;

        $query = DB::table('purchase_money_log as p');
        $inday = 0;
        if($dateCharge != '' && $dateCharge[0] == $dateCharge[1]){
            $query->select(DB::raw("HOUR(p.purchasedTime) purchase_date"), DB::raw('SUM(p.parValue) as sum_money'),  DB::raw('COUNT( DISTINCT user.userId) as total') );
            $inday = 1;
            $search = true;
        } else {
            $query->select(DB::raw("DATE(p.purchasedTime) purchase_date"), DB::raw('SUM(p.parValue) as sum_money'),  DB::raw('COUNT( DISTINCT user.userId) as total') );
        };
        if($cp){
            $query->where('user.cp', '=', $cp);
        }
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
                $query->whereBetween('user.lastLoginTime',[$start,$end]);
            }
        }


        if(!$search){
            $query->where("p.purchasedTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
            $query->where("user.lastLoginTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }

        if($inday == 1){
            $query->groupBy(DB::raw("HOUR(purchasedTime)"));
        } else {
            $query->groupBy(DB::raw("DATE(p.purchasedTime)"));
        }

        $data = $query->get()->toArray();


        return $data;
    }

    public static function getTotalRevenueUserPurchase($dateCharge, $cp = null)
    {
        $search = false;

        $query = DB::table('purchase_money_log as p');
        $inday = 0;
        if($dateCharge != '' && $dateCharge[0] == $dateCharge[1]){
            $query->select(DB::raw("HOUR(p.purchasedTime) purchase_date"), DB::raw('SUM(p.parValue) as sum_money'),  DB::raw('COUNT( DISTINCT p.userId) as total') );
            $inday = 1;
            $search = true;
        } else {
            $query->select(DB::raw("DATE(p.purchasedTime) purchase_date"), DB::raw('SUM(p.parValue) as sum_money'),  DB::raw('COUNT( DISTINCT p.userId) as total') );
        };
         $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($cp){
            $query->where('user.cp', '=', $cp);
        }
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }


        if(!$search){
           // $query->where("p.purchasedTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }

        if($inday == 1){
            $query->groupBy(DB::raw("HOUR(purchasedTime)"));
        } else {
            $query->groupBy(DB::raw("DATE(p.purchasedTime)"));
        }

        $data = $query->get()->toArray();


        return $data;
    }

        public static function getTotalRevenueUserLimit($date,  $type, $cp = null, $limit = null)
    {

        $query = DB::table('purchase_money_log as p');
        if($limit){
            $query->select(DB::raw('SUM(p.cashValue) as sum_money'),  DB::raw('p.userId') );
        } else {
            $query->select(DB::raw('SUM(p.cashValue) as sum_money'));
        }

         $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($cp){
            $query->where('user.cp', '=', $cp);
        }

        if($type){
            $query->where('p.type', '=', $type);
        }
        if($date != ''){
            $text = trim($date);
            $dateArr = explode('-', $text);
            if (count($dateArr) == 2) {
                $date1 = trim($dateArr[0]);
                $date1Arr = explode('/',  $date1);
                $date1Str = '';
                if (count($date1Arr) == 3) {
                    $date1Str = $date1Arr[2] . '-' . $date1Arr[0] . '-' . $date1Arr[1] . ' ' .  "00:00:00";
                }
                $date2 = trim($dateArr[1]);
                $date2Arr = explode('/', $date2);
                $date2Str = '';
                if (count($date2Arr) == 3) {
                    $date2Str = $date2Arr[2] . '-' . $date2Arr[0] . '-' . $date2Arr[1] . ' ' .  "23:59:59";
                }
                $query->whereBetween('purchasedTime', array($date1Str, $date2Str));
            }
        } else {
            $query->where("purchasedTime",  ">",  Date("Y-m-d"));
        }
        if($limit){
            $query->limit($limit);
            $query->orderBy('sum_money', 'desc');
            $query->groupBy("p.userId");
        }

        $data = $query->get()->toArray();


        return $data;
    }

}
