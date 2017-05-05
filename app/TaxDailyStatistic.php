<?php

namespace App;

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
            $query->where("a.day",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
        }

        if($gameId){
            $query->where('a.gameId','=', $gameId);
        }
        $data = $query->orderBy("a.day", "DESC")->get()->toArray();


        return $data;
    }
}
