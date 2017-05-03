<?php

namespace App\Http\Controllers\Admin\Basic;

use App\LoggedInLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class HistoryController extends Controller
{
    public function index(Request $request){
        $userName = \Request::get('userName');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');

        $query = LoggedInLog::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('loggedInTime',[$start,$end]);
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('userName')->paginate($perPage);

        return view('admin.basic.history.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
