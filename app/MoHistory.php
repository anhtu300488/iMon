<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class MoHistory extends Model
{
    protected $table = 'mo_history';
    public static function getTotalSMSRevenue($dateCharge)
    {
        $query = DB::table('mo_history as m');
        $query->select(DB::raw('m.telco as telco'), DB::raw('m.shortcode as shortcode'), DB::raw('SUM(m.amount) as sum_money') );

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
                $query->whereBetween('m.created_at',[$start,$end]);
            }
        }
        $query->groupBy('m.telco', 'm.shortcode');
        return $query->get()->toArray();
    }
}
