<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\MoneyLog;
use App\MoneyTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class IncomeMoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;
        $type = \Request::get('type') ? \Request::get('type') : 1 ;
        $transaction = \Request::get('transaction');

        $typeArr = array(1 => 'Mon');

        $transactionArr = array('' => '---Tất cả---', 2 => 'Nạp tiền', 3 => 'Quà tặng hệ thống', 7 => 'Giftcode');

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

        $query->whereIn('p.transactionId', [2,3,7]);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->groupBy(DB::raw("DATE(p.insertedTime)"), 'p.transactionId')->orderBy(DB::raw("DATE(p.insertedTime)"),'desc')->paginate($perPage);
        $results = MoneyLog::getSumByTransaction($transaction, $dateCharge, $type);
        $moneyArr = array();
        foreach ($results as $k => $v){
            $moneyArr[$v->created_date][$v->type] = $v->sum_money;
        }

        return view('admin.moneyGame.income.index',compact('data', 'typeArr', 'transactionArr', 'moneyArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function downloadExcel(){

        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;
        $type = \Request::get('type') ? \Request::get('type') : 1 ;
        $transaction = \Request::get('transaction');

        $typeArr = array(1 => 'Ken', 2 => 'Xu');

        $transactionArr = array('' => '---Tất cả---', 2 => 'Nạp tiền', 3 => 'Quà tặng hệ thống', 7 => 'Giftcode');

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

        $query->whereIn('p.transactionId', [2,3,7]);

        $results = $query->groupBy(DB::raw("DATE(p.insertedTime)"), 'p.transactionId')->orderBy(DB::raw("DATE(p.insertedTime)"),'desc')->get()->toArray();
        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = array(number_format($result->sum_money), $transactionArr[$result->type], $result->created_date);
        }
        // Generate and return the spreadsheet

        return \Maatwebsite\Excel\Facades\Excel::create('income', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $headings = array('Tổng tiền', 'Hình thức','Time');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }
}
