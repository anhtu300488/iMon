<?php

namespace App\Http\Controllers\Admin;

use App\ClientType;
use App\ExchangeAssetRequest;
use App\Partner;
use App\PurchaseMoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : explode(" - ", get7Day());
        $datePlayGame = \Request::get('date_play_game') ? explode(" - ", \Request::get('date_play_game')): null;
        $type = \Request::get('type');
        $cp = \Request::get('partner');
        $os = \Request::get('clientType');

        $typeArr = array('' => '---Tất cả---',1 => 'Thẻ cào', 2 => 'SMS', 3 => 'IAP');

        $partner = Partner::pluck('partnerName', 'partnerId');

        $partner->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $query = DB::table('purchase_money_log as p')->select(DB::raw("DATE(p.purchasedTime) created_date"), 'p.type as type',  DB::raw('SUM(p.parValue) as sum_money') , DB::raw('SUM(p.cashValue) as sum_cash'))
            ->join('user', function($join)
            {
                $join->on('user.userId', '=', 'p.userId');

            });
//        ->join('partner', function($join)
//        {
//            $join->on('partner.partnerId', '=', 'user.cp');
//
//        });
        if($type != null){
            $query->where(DB::raw('p.type'),'=', $type);
        }
//        if($cp != null){
//            $query->where(DB::raw('partner.partnerId'),'=', $cp);
//        }
        if($os != null){
            $query->where(DB::raw('user.clientId'),'=', $os);
        }
        if($userName != null){
            $query->where('p.userName','LIKE','%'.$userName.'%');
        }

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }

        if($datePlayGame != ''){
            $startPlayGame = $datePlayGame[0];

            $endPlayGame = $datePlayGame[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
            }
        }

        $query->where("p.purchasedTime",  ">",  Date("Y-m-d H:i:s", time() - 86400* 7));
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->groupBy(DB::raw("DATE(p.purchasedTime)"), 'p.type')->orderBy(DB::raw("DATE(p.purchasedTime)"),'desc')->paginate($perPage);
        $total_by_type = PurchaseMoneyLog::getTotalByType($type, $userName, $dateCharge, $datePlayGame, $cp, $os);
//        var_dump($total_by_type);die;
        $purchase_moneys = PurchaseMoneyLog::getTotalRevenueByDate($type, $userName, $dateCharge, $datePlayGame, $cp, $os);
        $exchange_moneys = ExchangeAssetRequest::getTotalRevenueByDate($dateCharge);
        $purchase_arr = array();
        foreach ($purchase_moneys as $index => $purchase_money){
            $purchase_arr[$purchase_money->purchase_date][$purchase_money->type] = array(isset($purchase_money->sum_money) ? $purchase_money->sum_money : 0, isset($purchase_money->sum_cash) ? $purchase_money->sum_cash : 0);
        }

        foreach ($exchange_moneys as $index => $exchange_money){
            $purchase_arr[$exchange_money->purchase_date][4] = $exchange_money->sum_money;
        }

        return view('admin.index',compact('data', 'partner', 'clientType', 'total_by_type', 'typeArr', 'purchase_arr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function statistic($fromDate,$toDate){
        $fromStr = str_replace('-', '/', $fromDate);
        $toStr = str_replace('-', '/', $toDate);
        $date = $fromStr.' - '.$toStr;
        $dateCharge = explode(" - ", $date);


        //get data of today
        $purchase_moneys = PurchaseMoneyLog::getTotalRevenueByDate(null, null, $dateCharge, null, null, null);

        $purchase_arr = array();
        $today_arr = array();
        $yesterday_arr = array();
        if(count($purchase_moneys) > 0){
            foreach ($purchase_moneys as $index => $purchase_money){
                $today_arr[$purchase_money->purchase_date][$purchase_money->type] = $purchase_money->sum_money;
            }
        }

        if(count($today_arr) > 0){
            foreach ($today_arr as $k => $v){
                $t1 = isset($v['1']) ? $v['1'] : 0;
                $t2 = isset($v['2']) ? $v['2'] : 0;
                $total = $t1 + $t2;
                $purchase_arr[$k][0] = $total ? $total : 0;
            }

        }
        //get data of yesterday
        $start[0] = $start[1] = date("m/d/Y",strtotime($dateCharge[0].' -1 days') );
        $purchase_moneys1 = PurchaseMoneyLog::getTotalRevenueByDate(null, null, $start, null, null, null);
        if(count($purchase_moneys1) > 0) {
            foreach ($purchase_moneys1 as $index => $purchase_money) {
                $yesterday_arr[$purchase_money->purchase_date][$purchase_money->type] = $purchase_money->sum_money;
            }
        }
        if(count($yesterday_arr) > 0){
            foreach ($yesterday_arr as $k => $v){
                $t1 = isset($v['1']) ? $v['1'] : 0;
                $t2 = isset($v['2']) ? $v['2'] : 0;
                $total = $t1 + $t2;
                $purchase_arr[$k][1] = $total ? $total : 0;
            }
        }
        return $purchase_arr;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
