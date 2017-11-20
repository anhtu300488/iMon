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
use App\Cp;
use Illuminate\Support\Facades\Auth;

class RevenueUserActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : explode(" - ", getToday());
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = DB::table('purchase_money_log as p')->select(DB::raw("DATE(p.purchasedTime) created_date"),  DB::raw('SUM(p.parValue) as sum_money') ,  DB::raw('COUNT( DISTINCT user.userId) as total'))
        ->join('user', function($join)
        {
            $join->on('user.userId', '=', 'p.userId');

        });
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;
        if($cp){
            $query->where('user.cp', '=',$cp);
        }
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('p.purchasedTime',[$start,$end]);
                $query->whereBetween('user.lastLoginTime',[$start,$end]);
            }
        }
       // $partner = Cp::where('cpId','!=', 1)->pluck('cpName', 'cpId');
        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');
        $partner->prepend('---Tất cả---', '');
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->groupBy(DB::raw("DATE(p.purchasedTime)"))->orderBy(DB::raw("DATE(p.purchasedTime)"),'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);
        $purchase_moneys = PurchaseMoneyLog::getTotalRevenueUserActive($dateCharge, $cp);
        $purchase_arr = array();

        foreach ($purchase_moneys as $index => $purchase_money){
            $purchase_arr[$purchase_money->purchase_date] = (isset($purchase_money->sum_money) ? $purchase_money->sum_money : 0)/ (isset($purchase_money->total) ? $purchase_money->total : 1);
        }

        return view('admin.revenue.revenueUserActive.index',compact('data','purchase_arr', 'partner'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
