<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PayCashOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;
        $userName = \Request::get('userName');

        $query = DB::table('exchange_asset_request as a');
        $query->select(DB::raw("SUM(a.totalParValue) sumMoney"), "a.requestUserId as userID", "a.requestUserName as userName", DB::raw("DATE(a.created_at) purchase_date" ));

        if($userName){
            $query->where('a.requestUserName','LIKE', '%'.$userName.'%');
        }

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


        $data = $query->groupBy(DB::raw("DATE(a.created_at)"), "a.requestUserId", "a.requestUserName")->orderBy(DB::raw("DATE(a.created_at)"), 'desc')->paginate(50);

        return view('admin.revenue.payCashOut.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 50);
    }
}
