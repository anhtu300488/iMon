<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TopCashOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;

        $query = DB::table('exchange_asset_request as a');
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'a.requestUserId');

        });
        $query->select(DB::raw("SUM(a.totalParValue) sumMoney"),  DB::raw("COUNT(a.requestId) sumCash"), "a.requestUserId as userID", "a.requestUserName as userName", "user.displayName as displayName" );
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
        $data = $query->groupBy("a.requestUserId", "a.requestUserName")->orderBy('sumMoney', 'desc')->paginate($perPage);

        return view('admin.revenue.topCashOut.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
