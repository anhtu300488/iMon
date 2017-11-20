<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Cp;
use App\PurchaseMoneyLog;

class TopChargingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : explode(" - ", get7Day());
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = DB::table('purchase_money_log as a');
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'a.userId');

        });
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;
        $type = \Request::get('type');
        $sum_top_10 = PurchaseMoneyLog::getTotalRevenueUserLimit(\Request::get('timeRequest'), $type, $cp, 10);
        $sum_all = PurchaseMoneyLog::getTotalRevenueUserLimit(\Request::get('timeRequest'), $type, $cp, null);
        $sum_money_top10 = 0;
        foreach ($sum_top_10 as $key => $value) {
            $sum_money_top10 = $sum_money_top10 + $value->sum_money;
        }
        $sum_money_top_all = $sum_all[0]->sum_money;
        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');
        $partner->prepend('---Tất cả---', '');



        $query->select(DB::raw("SUM(a.cashValue) sumMoney"), DB::raw("SUM(a.parValue) as sumVND"), "a.userId as userId", "a.userName as userName" , "user.displayName as displayName");
        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('a.purchasedTime',[$start1,$end1]);
            }
        }
        if($type){
            $query->where("a.type", '=', $type);
        }
//        $query->where('a.status','=',1);

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->groupBy("a.userId", "a.userName")->orderBy('sumMoney', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);
        // var_dump($data);die;
        return view('admin.revenue.topCharging.index',compact('data', 'sum_money_top10', 'sum_money_top_all', 'partner'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
