<?php

namespace App\Http\Controllers\Admin\Basic;

use App\MoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class KenHistoryController extends Controller
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
        $query = MoneyLog::query()->where('changeCash','>',0);
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
//        if($fromDate != '' && $toDate != ''){
//            $start = date("Y-m-d",strtotime($fromDate));
//            $end = date("Y-m-d",strtotime($toDate));
//            $query->whereBetween('purchasedTime',[$start,$end]);
//        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('userName')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.basic.kenHistory.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
