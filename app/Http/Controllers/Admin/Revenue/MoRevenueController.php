<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\MoHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MoRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userID = \Request::get('userId');
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;
        $phone = \Request::get('phone');
        $mo = \Request::get('mo');
        $shortCode = \Request::get('shortCode');
        $telco = \Request::get('telco');

        $matchThese = [];
        if($userID != ''){
            $matchThese['userId'] = $userID;
        }

        $query = MoHistory::query();
        if($phone != ''){
            $query->where('phone_number','LIKE','%'.$phone.'%');
        }

        if($mo != ''){
            $query->where('mo_id','LIKE','%'.$mo.'%');
        }

        if($shortCode != ''){
            $query->where('shortcode','LIKE','%'.$shortCode.'%');
        }

        if($telco != ''){
            $query->where('telco','LIKE','%'.$telco.'%');
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

        $data = $query->orderBy('created_at','desc')->paginate(10);

        return view('admin.revenue.moRevenue.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
