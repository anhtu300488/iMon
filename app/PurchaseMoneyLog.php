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
        $query->select(DB::raw('SUM(parValue) as sum_money',DB::raw('SUM(cashValue) as sum_cash')));

//        $query->where($alias. ".money > 0");
//        $query->andWhere("status = 1");
        if ($dateCharge) {
            $text = trim($dateCharge);
            $dateArr = explode('-', $text);
            if (count($dateArr) == 2) {
                $date1 = trim($dateArr[0]);
                $day_time1 = explode(' ', $date1);
                $date1Arr = explode('/', $day_time1[0]);
                $date1Str = '';
                $day1= $date1Arr[2] . '-' . $date1Arr[1] . '-' . $date1Arr[0];
                if (count($date1Arr) == 3) {
                    $date1Str = $day1 . ' ' .  $day_time1[1];
                }
                $date2 = trim($dateArr[1]);
                $day_time2 = explode(' ', $date2);
                $date2Arr = explode('/', $day_time2[0]);
                $date2Str = '';
                $day2 =  $date2Arr[2] . '-' . $date2Arr[1] . '-' . $date2Arr[0];
                if (count($date2Arr) == 3) {
                    $date2Str = $day2 . ' ' .  $day_time2[1];
                }
                $query->whereBetween('purchasedTime', [$date1Str, $date2Str]);
            }
        }
        if ($datePlayGame) {
            $text = trim($datePlayGame);
            $dateArr = explode('-', $text);
            if (count($dateArr) == 2) {
                $date1 = trim($dateArr[0]);
                $day_time1 = explode(' ', $date1);
                $date1Arr = explode('/', $day_time1[0]);
                $date1Str = '';
                $day1= $date1Arr[2] . '-' . $date1Arr[1] . '-' . $date1Arr[0];
                if (count($date1Arr) == 3) {
                    $date1Str = $day1 . ' ' .  $day_time1[1];
                }
                $date2 = trim($dateArr[1]);
                $day_time2 = explode(' ', $date2);
                $date2Arr = explode('/', $day_time2[0]);
                $date2Str = '';
                $day2 =  $date2Arr[2] . '-' . $date2Arr[1] . '-' . $date2Arr[0];
                if (count($date2Arr) == 3) {
                    $date2Str = $day2 . ' ' .  $day_time2[1];
                }
                $query->whereBetween('startPlayedTime', [$date1Str, $date2Str]);

            }
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
//        $query->leftJoin("user", 'users.id', '=', 'contacts.user_id');
//        $query->leftJoin("partner", 'partner.id', '=', 'contacts.user_id');
         $query->groupBy("type");
        return $query->get()->toArray();
    }
}
