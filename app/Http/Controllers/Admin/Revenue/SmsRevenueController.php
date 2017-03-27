<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\MoHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SmsRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;
        $keywords = \Request::get('keywords');
        $amount = \Request::get('amount');

        $matchThese = [];
        if($amount != ''){
            $matchThese['amount'] = $amount;
        }

        $query = MoHistory::query()->select(DB::raw("DATE(created_at) created_at"),  DB::raw('SUM(amount) as sum_money') );
        if($keywords != ''){
            $query->where('keyword','LIKE','%'.$keywords.'%');
        }

        $query->where($matchThese);

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('created_at',[$start,$end]);
            }
        }

        $data = $query->groupBy(DB::raw("DATE(created_at)"))->orderBy('created_at','desc')->paginate(10);

        return view('admin.revenue.smsRevenue.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
