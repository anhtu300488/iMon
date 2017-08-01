<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class VipController extends Controller
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

        $query = DB::table('user as a');
        $query->join('purchase_money_log', function($join)
        {
            $join->on('purchase_money_log.userId', '=', 'a.userId');

        });
        $query->select(DB::raw("COUNT(purchase_money_log.userId) numberExchange"), DB::raw("SUM(purchase_money_log.parValue) sumMoney"), 'a.*' );

        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('purchase_money_log.purchasedTime',[$start1,$end1]);
            }
        }

//        $query->where('a.status','=',1);

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $data = $query->groupBy("purchase_money_log.userId")->orderBy(DB::raw("a.totalMoneyCharged"), 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

//        var_dump($data);die;

        return view('admin.revenue.vip.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
