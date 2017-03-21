<?php

namespace App\Http\Controllers\Admin\Basic;

use App\PurchaseMoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TopUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');

        $query = PurchaseMoneyLog::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $query->select("userId", "userName",DB::raw('SUM(cashValue) as sum_cash'));
        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('purchasedTime',[$start . " 00:00:00",$end . " 23:59:59"]);
        }
        $query->groupBy("userId", "userName");
        $query->orderBy("sum_cash", "desc");
        $data = $query->paginate(10);
        return view('admin.basic.topUser.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
