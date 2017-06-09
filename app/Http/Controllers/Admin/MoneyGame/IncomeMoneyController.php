<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\MoneyLog;
use App\MoneyTransaction;
use Carbon\Carbon;
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
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : explode(" - ", getToday());
        $type = \Request::get('type') ? \Request::get('type') : 1 ;
        $transaction = \Request::get('transaction');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $typeArr = array(1 => 'Mon');

        $transactionArr = array('' => '---Tất cả---', 2 => 'Nạp tiền', 31 => 'Xác thực tài khoản', 32 => 'Quà tặng giờ vàng', 7 => 'Giftcode', 10 => 'Thưởng nhiệm vụ', 11 => 'Đăng ký tài khoản');

        $matchThese = [];
        if($transaction != '' && $transaction != 31 && $transaction != 32){
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

        if($transaction == 32){
            $query->where("p.transactionId",  "=",  3);
            $query->where("p.description",  "LIKE",  '%Quà tặng giờ vàng%');
        }

        if($transaction == 31){
            $query->where("p.transactionId",  "=",  3);
            $query->where("p.description",  "=",  'Xác thực tài khoản');
        }

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.insertedTime',[$start,$end]);
            }
        } else{
            $query->where("p.insertedTime",  ">",  Date("Y-m-d H:i:s", strtotime(Carbon::now().' -7 days')));
        }

        $query->whereIn('p.transactionId', [2,3,7,10,11]);

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->groupBy(DB::raw("DATE(p.insertedTime)"), 'p.transactionId')->orderBy(DB::raw("DATE(p.insertedTime)"),'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);
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
