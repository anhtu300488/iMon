<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Cp;
use App\LogPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $userId = \Request::get('userId');
        $userName = \Request::get('userName');
        $displayName = \Request::get('displayName');
        $seria = \Request::get('seria');
        $pinCard = \Request::get('pinCard');
        $money = \Request::get('money');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;
        $partner = Cp::where('cpId','!=', 1)->pluck('cpName', 'cpId');

        $partner->prepend('---Tất cả---', '');
        $query = LogPayment::query();
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'log_payment.userId');

        });
        $matchThese = [];
        if($money != ''){
            $matchThese['money'] = $money;
        }

        if($seria != ''){
            $query->where('seria','LIKE','%'.$seria.'%');
        }

        if($pinCard != ''){
            $query->where('pin_card','LIKE','%'.$pinCard.'%');
        }
        if($userId != ''){
            $query->where('log_payment.userId','=',$userId);
        }
        if($cp != ''){
            $query->where('user.cp','=',$cp);
        }
        if($userName != ''){
            $query->where('user.userName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
        }

        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at','desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.revenue.logPayment.index',compact('data','partner'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
