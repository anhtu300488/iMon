<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MoneyLog extends Model
{
    protected $table = 'money_log';


    public static function getSumByTransaction($transaction, $dateCharge, $type){
        $matchThese = [];
        if($transaction != ''){
            $matchThese['p.transactionId'] = $transaction;
        }

        $query = DB::table('money_log as p');
        if($type == 1){
            $query->select(DB::raw("DATE(p.insertedTime) created_date"), 'p.transactionId as type', DB::raw('SUM(p.changeCash) as sum_money'));
        } else{
            $query->select(DB::raw("DATE(p.insertedTime) created_date"), 'p.transactionId as type', DB::raw('SUM(p.changeCash) as sum_money'));
        }

        $query->join('money_transaction', function($join)
            {
                $join->on('money_transaction.transactionId', '=', 'p.transactionId');

            });

        $query->where($matchThese);

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.insertedTime',[$start,$end]);
            }
        } else{
            $query->where("p.insertedTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days')));
        }

        $query->where('p.transactionId', '!=', 1);


        $data = $query->groupBy(DB::raw("DATE(p.insertedTime)"), 'p.transactionId')->orderBy(DB::raw("DATE(p.insertedTime)"),'asc')->get()->toArray();

        return $data;
    }
}
