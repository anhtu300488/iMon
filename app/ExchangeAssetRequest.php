<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExchangeAssetRequest extends Model
{
    protected $table = 'exchange_asset_request';

    public static function getTotalRevenueByDate($timeRequest)
    {

        $search = false;

        $query = DB::table('exchange_asset_request as a');
        $inday = 0;
        if($timeRequest != '' && $timeRequest[0] == $timeRequest[1]){
            $query->select(DB::raw("SUM(a.totalParValue) sum_money"),  DB::raw("COUNT(a.requestId) sumCash"), DB::raw("HOUR(a.created_at) purchase_date") );
            $inday = 1;
            $search = true;
        } else {
            $query->select(DB::raw("SUM(a.totalParValue) sum_money"),  DB::raw("COUNT(a.requestId) sumCash"), DB::raw("DATE(a.created_at) purchase_date") );
        };
//            ->select(DB::raw("SUM(a.totalParValue) sum_money"), DB::raw("DATE(a.created_at) purchase_date"));

        if($timeRequest != ''){
            $search = true;
            $startDateCharge = $timeRequest[0];

            $endDateCharge = $timeRequest[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('a.created_at',[$start,$end]);
            }
        }

        if(!$search){
            $query->where("a.created_at",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
        }

        if($inday == 1){
            $query->groupBy(DB::raw("HOUR(a.created_at)"));
        } else {
            $query->groupBy(DB::raw("DATE(a.created_at)"));
        }

//        $query->groupBy(DB::raw("DATE(a.created_at)"));

        $data = $query->get()->toArray();


        return $data;
    }
}
