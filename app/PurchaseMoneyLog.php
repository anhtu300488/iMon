<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class PurchaseMoneyLog extends Model
{
    protected $table = 'purchase_money_log';

    public function users()
    {
        return $this->belongsToMany('App\UserReg', 'user','userId');
    }
    public static function getTotalByType($type, $userName, $dateCharge, $datePlayGame, $cp, $os)
    {
//        $query = PurchaseMoneyLog::query();
//        if($userName != ''){
//            $query->where('userName','LIKE','%'.$userName.'%');
//        }
//        $query->select("userId", "userName",DB::raw('SUM(cashValue) as sum_cash'));
//        if($fromDate != '' && $toDate != ''){
//            $start = date("Y-m-d",strtotime($fromDate));
//            $end = date("Y-m-d",strtotime($toDate));
//            $query->whereBetween('purchasedTime',[$start . " 00:00:00",$end . " 23:59:59"]);
//        }
//        $query->groupBy("userId", "userName");
//        $query->orderBy("sum_cash", "desc");


        $query = PurchaseMoneyLog::query();
//        $query->select("sum(a.parValue) as sum_money, sum(a.cashValue) as sum_cash, a.type");
        $query->select("type", DB::raw('SUM(parValue) as sum_money',DB::raw('SUM(cashValue) as sum_cash')));

//        $query->where($alias. ".money > 0");
//        $query->andWhere("status = 1");

        if ($dateCharge) {
                $query->whereBetween('purchasedTime', [$dateCharge[0], $dateCharge[1]]);
        }
        if ($datePlayGame) {
                $query->whereBetween('user.startPlayedTime', [$datePlayGame[0], $datePlayGame[1]]);
        }
        if($type){
            $query->where('type ','=',$type);
        }
        if($cp){
            $query->where('cp ','=',$cp);
        }
        if($os){
            $query->where('clientID ','=',$type);
        }
        if($userName){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
//        if(sfContext::getInstance()->getUser()->hasCredential('cp_truyenthong')){
//            $cp_id = PartnerTable::getCpIdByAdmin();
//            $query->andWhere("g.cp = ?", $cp_id);
//        }
        $query->leftJoin("user", 'user.userId', '=', 'purchase_money_log.userId');
//        $query->leftJoin("partner", 'partner.id', '=', 'contacts.user_id');
         $query->groupBy("type");
        return $query->get()->toArray();
    }
    public static function getTotalRevenueByDate($type, $userName, $dateCharge, $datePlayGame, $cp, $os)
    {
//        $query = PurchaseMoneyLog::query();
//
//        $inday = false;
//        $search = false;
//
//        if($dateCharge != ''){
//            $startDateCharge = $dateCharge[0];
//
//            $endDateCharge = $dateCharge[1];
//
//            if($startDateCharge != '' && $endDateCharge != ''){
//                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
//                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
//                $query->whereBetween('purchasedTime',[$start,$end]);
//            }
//        }
//
//        if($datePlayGame != ''){
//            $startPlayGame = $datePlayGame[0];
//
//            $endPlayGame = $datePlayGame[1];
//
//            if($startPlayGame != '' && $endPlayGame != ''){
//                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
//                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
//                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
//            }
//        }
//
////        if($type){
////            $query->where('p.type ','=',$type);
////        }
////        if($cp){
////            $query->where('p.cp ','=',$cp);
////        }
////        if($os){
////            $query->where('p.clientID ','=',$type);
////        }
//        if($userName){
//            $query->where('userName','LIKE','%'.$userName.'%');
//        }
//
//        $inday = 0;
//        if($dateCharge[0] = $dateCharge[1]){
//            $query->select("type", DB::raw('SUM(parValue) as sum_money',DB::raw('SUM(cashValue) as sum_cash'),DB::raw('hour(purchasedTime) as purchase_date') ));
//            $inday =1;
//            $search = true;
////            $query->select("sum(a.parValue) as sum_money, sum(a.cashValue) as sum_cash, a.type, hour(a.purchasedTime) as purchase_date");
//        } else {
//            $query->select("type", DB::raw('SUM(parValue) as sum_money',DB::raw('SUM(cashValue) as sum_cash'),DB::raw('DATE(purchasedTime) as purchase_date') ));
////            $query->select("sum(a.parValue) as sum_money, sum(a.cashValue) as sum_cash, a.type, DATE(a.purchasedTime) as purchase_date");
//        }
//        $query->leftJoin("user", 'user.userId', '=', 'userId');
////        $query->leftJoin("g.Partner p");
//        if($inday = 1){
//            $query->groupBy("hour(purchasedTime) , type");
//        } else {
//            $query->groupBy("DATE(purchasedTime ) , type");
//        }
//        $query->orderBy(" purchasedTime asc");
////        if(!$search){
////            $query->where("purchasedTime > ?",  Date("Y-m-d H:i:s", time() - 86400* 7));
////        }
//        return $query->get()->toArray();


        $matchThese = [];
        if($type != ''){
            $matchThese['type'] = $type;
        }

        $query = DB::table('purchase_money_log as p')->select(DB::raw("DATE(p.purchasedTime) purchase_date"), 'p.type as type',  DB::raw('SUM(p.parValue) as sum_money') , DB::raw('SUM(p.cashValue) as sum_cash') )
            ->join('user', function($join)
            {
                $join->on('user.userId', '=', 'p.userId');

            })
            ->join('partner', function($join)
            {
                $join->on('partner.partnerId', '=', 'user.cp');

            });
        if($userName != ''){
            $query->where('p.userName','LIKE','%'.$userName.'%');
        }
        $query->where($matchThese);

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

        $data = $query->groupBy(DB::raw("DATE(p.purchasedTime)"), 'type')->orderBy(DB::raw("DATE(p.purchasedTime)"),'desc')->get()->toArray();


        return $data;
    }


}
