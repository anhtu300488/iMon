<?php

namespace App;

use Carbon\Carbon;
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

    public function blackListUser()
    {
        return $this->hasOne('App\BlackListUser', 'userId', 'userId');
    }

    public static function getTotalUserByOs($cp)
    {
        $query = DB::table('user as a')
            ->select(DB::raw("count(a.clientId) as sum_os"), DB::raw("p.name as name"), "a.clientId as clientId")
            ->leftJoin('client_type as p', 'a.clientId', '=', 'p.clientId');
//            ->leftJoin('client_type', function($join)
//            {
//                $join->on('client_type.clientId', '=', 'a.clientId');
//
//            });
        if($cp != null){
            $query->where('a.cp','=', $cp);
        }
        $query ->groupBy("a.clientId");
        $query->orderBy("sum_os", "desc");
        return $query->get()->toArray();

    }

    public static function getRegisterInfo($created_at, $cp)
    {
        $query =  DB::table('user as a')
            ->select (DB::raw('count(a.userId) count'), DB::raw('date(a.registedTime) date') )
            ->where("a.registedTime", ">" , $created_at);
        if($cp != null){
            $query->where('a.cp','=', $cp);
        }
        $query->groupBy(DB::raw('date(registedTime)'));

        return $query ->get()->toArray();
    }

    public static function getRegisterInfoNew($created_at, $cp)
    {
        $query = DB::table('user as a')
            ->select (DB::raw('count(DISTINCT a.deviceIdentify) count'), DB::raw('date(a.registedTime) date') )
            ->groupBy(DB::raw('date(a.registedTime)'))
            ->where("a.registedTime", ">", $created_at);
        if($cp != null){
            $query->where('a.cp','=', $cp);
        }
        return $query->get()->toArray();
    }

    public static function getPlayUserInday($created_at, $cp)
    {
        $query =  DB::table('user as a')
            ->select (DB::raw('count(DISTINCT a.deviceIdentify) count'), DB::raw('date(a.lastLoginTime) date') )
            ->groupBy(DB::raw('date(a.lastLoginTime)'))
            ->where("a.lastLoginTime", ">", $created_at);
        if($cp != null){
            $query->where('a.cp','=', $cp);
        }
        return $query->get()->toArray();
    }

    public static function getTotalUserRegByDay($loginTime)
    {
        $startDateCharge = $loginTime ? date("Y-m-d",strtotime($loginTime[0])) : Date("Y-m-d", strtotime(Carbon::now().' -7 days'));
        return UserReg::whereDate('registedTime', '=', $startDateCharge)->count();
    }
}
