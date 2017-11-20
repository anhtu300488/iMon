<?php

namespace App\Http\Controllers\Admin\Gateway;

use Illuminate\Support\Facades\DB;
use App\Cp;
use App\SmsThang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SmsThangController extends Controller
{
    public function index(Request $request){
        $msisdn = \Request::get('msisdn');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        if($msisdn != ''){
            $matchThese['msisdn'] = $msisdn;
        }
        $query = SmsThang::query();

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);
        $queryMoney = DB::table('sms_thang as m');
        $queryMoney->select( DB::raw('SUM(m.amount) as sum_money'));
        $queryMoney->get()->toArray();
        var_dump($queryMoney);die;


        return view('admin.gate.smsThang.index',compact('data', 'sumMoney', 'providerArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
