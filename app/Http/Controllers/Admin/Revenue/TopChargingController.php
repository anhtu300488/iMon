<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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
        $type = \Request::get('type');

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

        return view('admin.revenue.topCharging.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
