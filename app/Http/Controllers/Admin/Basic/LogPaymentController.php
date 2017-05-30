<?php

namespace App\Http\Controllers\Admin\Basic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LogPayment;
use DB;
use Illuminate\Support\Facades\Config;

class LogPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = \Request::get('userid');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $payType = \Request::get('payType');
        $cardType = \Request::get('cardType');
        $os = \Request::get('os');
        $page = \Request::get('page') ? \Request::get('page') : 1;
//        $matchThese = ['userid' => $userid, 'payType' => $payType, 'cardType' => $cardType, 'os' => $os];
        $matchThese = [];
        if($userid != ''){
            $matchThese['userid'] = $userid;
        }
//        $matchThese = ['userid' => $userid];
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = LogPayment::where($matchThese)->orderBy('id')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.basic.logPayment.index',compact('data'));
    }
}
