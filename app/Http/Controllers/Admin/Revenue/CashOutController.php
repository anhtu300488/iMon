<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CashOutController extends Controller
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

//        $query = ExchangeAssetRequest::query();
        $query = DB::table('exchange_asset_request as a');
        $query->select(DB::raw("SUM(a.totalParValue) sumMoney"),  DB::raw("COUNT(a.requestId) sumCash"), DB::raw("DATE(a.created_at) purchase_date"));
        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('a.created_at',[$start1,$end1]);
            }
        }

        $query->where('a.status','=',1);

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->groupBy(DB::raw("DATE(a.created_at)"))->orderBy(DB::raw("DATE(a.created_at)"), 'desc')->limit($startLimit,$endLimit)->paginate($perPage);
        $purchase_arr = array();
        $purchase_moneys = ExchangeAssetRequest::getTotalRevenueByDate($timeRequest);

        foreach ($purchase_moneys as $index => $purchase_money){
            $purchase_arr[$purchase_money->purchase_date][0] = $purchase_money->sum_money;
            $purchase_arr[$purchase_money->purchase_date][1] = $purchase_money->sumCash;
        }

        return view('admin.revenue.cashOut.index',compact('data', 'purchase_arr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
