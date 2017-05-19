<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\MoneyLog;
use App\MoneyTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CirculationMoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        die('1');
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : explode(" - ", getToday());
        $type = \Request::get('type') ? \Request::get('type') : 1 ;
        $transaction = \Request::get('transaction') ? \Request::get('transaction') : 6;
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $typeArr = array(1 => 'Mon');

        $transactionArr = array(6 => 'Đổi thưởng', 1 => 'Chơi game');

        $matchThese = [];
        if($transaction != ''){
            $matchThese['p.transactionId'] = $transaction;
        }

        $query = DB::table('money_log as p');
        if($type == 1){
            $query->select(DB::raw("DATE(p.insertedTime) created_date"), 'p.transactionId as type', DB::raw('SUM(p.currentCash) as sum_money'));
        } else{
            $query->select(DB::raw("DATE(p.insertedTime) created_date"), 'p.transactionId as type', DB::raw('SUM(p.currentGold) as sum_money'));
        }
//        ->select(DB::raw("DATE(p.insertedTime) created_date"), 'money_transaction.type as type',  DB::raw('SUM(p.currentCash) as sum_money') , DB::raw('SUM(p.currentGold) as sum_cash'))
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
            $query->where("p.insertedTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
        }

        $query->whereIn('p.transactionId', [1,6]);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->groupBy(DB::raw("DATE(p.insertedTime)"), 'p.transactionId')->orderBy(DB::raw("DATE(p.insertedTime)"),'desc')->limit($startLimit,$endLimit)->paginate($perPage);
        $results = MoneyLog::getSumByTransaction($transaction, $dateCharge, $type);
        $moneyArr = array();
        foreach ($results as $k => $v){
            $moneyArr[$v->created_date][$v->type] = $v->sum_money;
        }

        return view('admin.moneyGame.circulation.index',compact('data', 'typeArr', 'transactionArr', 'moneyArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
