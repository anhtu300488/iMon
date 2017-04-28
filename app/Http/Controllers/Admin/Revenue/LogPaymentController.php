<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\LogPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class LogPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $seria = \Request::get('seria');
        $pinCard = \Request::get('pinCard');
        $money = \Request::get('money');

        $matchThese = [];
        if($money != ''){
            $matchThese['money'] = $money;
        }

        $query = LogPayment::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($seria != ''){
            $query->where('seria','LIKE','%'.$seria.'%');
        }

        if($pinCard != ''){
            $query->where('pin_card','LIKE','%'.$pinCard.'%');
        }


        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = $query->orderBy('created_at','desc')->paginate($perPage);

        return view('admin.revenue.logPayment.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
