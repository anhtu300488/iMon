<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class MoHistory extends Model
{
    protected $table = 'mo_history';

    public static function getTotalSMSRevenue($dateCharge, $cp)
    {
        $query = DB::table('mo_history as m');
        $query->select(DB::raw('m.telco as telco'), DB::raw('m.shortcode as shortcode'), DB::raw('SUM(m.amount) as sum_money') );
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'm.user_id');

        });
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];
            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('m.created_at',[$start,$end]);
            }
        } else {
            $query->where("m.created_at",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days') ));
        }
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        $query->groupBy('m.telco', 'm.shortcode');
        return $query->get()->toArray();
    }
    public static function getTotalRevenueByDate($timeRequest,$cp)
    {

        $search = false;

        $query = DB::table('mo_history as a');
        $inday = 0;
        if($timeRequest != '' && $timeRequest[0] == $timeRequest[1]){
            $query->select(DB::raw("SUM(a.amount) sum_money"), DB::raw("HOUR(a.created_at) purchase_date") );
            $inday = 1;
            $search = true;
        } else {
            $query->select(DB::raw("SUM(a.amount) sum_money"), DB::raw("DATE(a.created_at) purchase_date") );
        };
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'a.user_id');

        });
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
            $query->where("a.created_at",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
//        $query->where("a.status", '=', 1);

        if($inday == 1){
            $query->groupBy(DB::raw("HOUR(a.created_at)"));
        } else {
            $query->groupBy(DB::raw("DATE(a.created_at)"));
        }

        $data = $query->get()->toArray();


        return $data;
    }
}
