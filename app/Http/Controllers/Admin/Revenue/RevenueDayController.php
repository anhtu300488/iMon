<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ClientType;
use App\ExchangeAssetRequest;
use App\Partner;
use App\PurchaseMoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RevenueDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;
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

        $data = $query->groupBy(DB::raw("DATE(p.purchasedTime)"), 'p.type')->orderBy(DB::raw("DATE(p.purchasedTime)"),'desc')->paginate(10);
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

        return view('admin.revenue.revenueDay.index',compact('data', 'partner', 'clientType', 'total_by_type', 'typeArr', 'purchase_arr'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
