<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TaxDailyStatistic extends Model
{
    protected $table = 'tax_daily_statistic';

    public static function getRevenueGroupByDateFromTo($gameId = null, $timeRequest)
    {
        $query = DB::table('tax_daily_statistic as a');
        $query->select("taxValue","day","gameId");

        if($timeRequest != ''){
            $startDateCharge = $timeRequest[0];
            $endDateCharge = $timeRequest[1];
            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('a.day',[$start,$end]);
            }
        } else {
            $query->where("a.day",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }

        if($gameId){
            $query->where('a.gameId','=', $gameId);
        }
        $query->whereNull('a.hour');
        $data = $query->orderBy("a.day", "DESC")->get()->toArray();


        return $data;
    }

    public static function getRevenueGroupByDateNow($gameId = null)
    {
        $query = DB::table('tax_daily_statistic as a');
        $query->select(DB::raw('SUM(a.taxValue) as taxValue'),"day","gameId");

        $query->whereDate('a.day', date('Y-m-d', strtotime(Carbon::now())));

        if($gameId){
            $query->where('a.gameId','=', $gameId);
        }
//        $query->whereNull('a.hour');
        $data = $query->groupBy('day', 'gameId' )->orderBy("a.day", "DESC")->get()->toArray();


        return $data;
    }
}
