<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ClientType;
use App\ExchangeAssetRequest;
use App\Partner;
use App\PurchaseMoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RevenueUserPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;

        $query = DB::table('purchase_money_log as p')->select(DB::raw("DATE(p.purchasedTime) created_date"),  DB::raw('SUM(p.parValue) as sum_money') ,  DB::raw('COUNT( DISTINCT p.userId) as total'));


        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
            }
        }

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->groupBy(DB::raw("DATE(p.purchasedTime)"))->orderBy(DB::raw("DATE(p.purchasedTime)"),'desc')->paginate($perPage);
        $purchase_moneys = PurchaseMoneyLog::getTotalRevenueUserPurchase($dateCharge);
        $purchase_arr = array();

        foreach ($purchase_moneys as $index => $purchase_money){
            $purchase_arr[$purchase_money->purchase_date] = (isset($purchase_money->sum_money) ? $purchase_money->sum_money : 0)/ (isset($purchase_money->total) ? $purchase_money->total : 1);
        }

        return view('admin.revenue.revenueUserPurchase.index',compact('data','purchase_arr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
