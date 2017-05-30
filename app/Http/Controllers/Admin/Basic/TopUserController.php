<?php

namespace App\Http\Controllers\Admin\Basic;

use App\PurchaseMoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
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
        $page = \Request::get('page') ? \Request::get('page') : 1;

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
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->offset($startLimit)->limit($perPage)->paginate($perPage);
        return view('admin.basic.topUser.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
