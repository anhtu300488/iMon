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
        $query->join('exchange_asset_request', function($join)
        {
            $join->on('exchange_asset_request.requestUserId', '=', 'a.userId');

        });
        $query->select(DB::raw("COUNT(exchange_asset_request.requestUserId) numberExchange"), DB::raw("SUM(exchange_asset_request.totalParValue) sumMoney"), 'a.*' );

        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('exchange_asset_request.created_at',[$start1,$end1]);
            }
        }

//        $query->where('a.status','=',1);

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $data = $query->groupBy("exchange_asset_request.requestUserId")->orderBy(DB::raw("a.vipLevel"), 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

//        var_dump($data);die;

        return view('admin.revenue.vip.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
