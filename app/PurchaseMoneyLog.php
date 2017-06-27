<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class PurchaseMoneyLog extends Model
{
    protected $table = 'purchase_money_log';

    public function users()
    {
        return $this->belongsToMany('App\UserReg', 'user','userId');
    }
    public static function getSumRevenuShare($dateCharge)
    {
        $query = DB::table('purchase_money_log as p');
        $query->select(DB::raw('SUM(p.parValue) as sum_money'));

//            ->join('partner', function($join)
//            {
//                $join->on('partner.partnerId', '=', 'user.cp');
//
//            });

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }

//        if(sfContext::getInstance()->getUser()->hasCredential('cp_truyenthong')){
//            $cp_id = PartnerTable::getCpIdByAdmin();
//            $query->andWhere("g.cp = ?", $cp_id);
//        }
//        $query->leftJoin("user", 'user.userId', '=', 'purchase_money_log.userId');
//        $query->leftJoin("partner", 'partner.id', '=', 'contacts.user_id');
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
    public static function getTotalRevenueByDate($type, $userName, $dateCharge, $datePlayGame, $cp, $os)
    {
        $search = false;

        $query = DB::table('purchase_money_log as p');
        $inday = 0;
        if($dateCharge != '' && $dateCharge[0] == $dateCharge[1]){
            $query->select(DB::raw("HOUR(p.purchasedTime) purchase_date"), 'p.type as type',  DB::raw('SUM(p.parValue) as sum_money') , DB::raw('SUM(p.cashValue) as sum_cash') );
            $inday = 1;
            $search = true;
        } else {
            $query->select(DB::raw("DATE(p.purchasedTime) purchase_date"), 'p.type as type',  DB::raw('SUM(p.parValue) as sum_money') , DB::raw('SUM(p.cashValue) as sum_cash') );
        };

        $query->join('user', function($join)
            {
                $join->on('user.userId', '=', 'p.userId');

            });
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

    public static function getTotalRevenueUserActive($dateCharge)
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

        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });

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

    public static function getTotalRevenueUserPurchase($dateCharge)
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
            $query->where("p.purchasedTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }

        if($inday == 1){
            $query->groupBy(DB::raw("HOUR(purchasedTime)"));
        } else {
            $query->groupBy(DB::raw("DATE(p.purchasedTime)"));
        }

        $data = $query->get()->toArray();


        return $data;
    }

}
