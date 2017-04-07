<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserReg extends Model
{
    protected $table = 'user';

    public $timestamps = false;

    protected $primaryKey = 'userId';

    public function purchaseMoneyLogs()
    {
        return $this->belongsToMany('App\PurchaseMoneyLog', 'purchase_money_log');
    }

    public static function getTotalUserByOs()
    {
        $query = DB::table('user as a')
            ->select(DB::raw("count(a.clientId) as sum_os"), "client_type.name as name", "a.clientId as clientId")
            ->join('client_type', function($join)
            {
                $join->on('client_type.clientId', '=', 'a.clientId');

            });
        $query ->groupBy("a.clientId");
        $query->orderBy("sum_os", "desc");
        return $query->get()->toArray();

    }

    public static function getRegisterInfo($created_at)
    {
        $query =  DB::table('user as a')
            ->select (DB::raw('count(a.userId) count'), DB::raw('date(a.registedTime) date') )
            ->where("a.registedTime", ">" , $created_at);
//        $cp_truyenthong     = sfContext::getInstance()->getUser()->hasCredential('cp_truyenthong');
//        if($cp_truyenthong){
//            $cp_id = PartnerTable::getCpIdByAdmin();
//            $query->andWhere("a.cp = ?", $cp_id);
//        }
        $query->groupBy(DB::raw('date(registedTime)'));

        return $query ->get()->toArray();
    }

    public static function getRegisterInfoNew($created_at)
    {
        $query = DB::table('user as a')
            ->select (DB::raw('count(DISTINCT a.deviceIdentify) count'), DB::raw('date(a.registedTime) date') )
            ->groupBy(DB::raw('date(a.registedTime)'))
            ->where("a.registedTime", ">", $created_at);
//        $cp_truyenthong     = sfContext::getInstance()->getUser()->hasCredential('cp_truyenthong');
//        if($cp_truyenthong){
//            $cp_id = PartnerTable::getCpIdByAdmin();
//            $query->andWhere("g.cp = ?", $cp_id);
//        }
        return $query->get()->toArray();
    }

    public static function getPlayUserInday($created_at)
    {
        $query =  DB::table('user as a')
            ->select (DB::raw('count(DISTINCT a.deviceIdentify) count'), DB::raw('date(a.lastLoginTime) date') )
            ->groupBy(DB::raw('date(a.lastLoginTime)'))
            ->where("a.lastLoginTime", ">", $created_at);
//        $cp_truyenthong     = sfContext::getInstance()->getUser()->hasCredential('cp_truyenthong');
//        if($cp_truyenthong){
//            $cp_id = PartnerTable::getCpIdByAdmin();
//            $query->andWhere("a.cp = ?", $cp_id);
//        }
        return $query->get()->toArray();
    }
}
