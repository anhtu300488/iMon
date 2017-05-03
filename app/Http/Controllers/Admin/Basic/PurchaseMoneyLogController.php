<?php

namespace App\Http\Controllers\Admin\Basic;

use App\ClientType;
use App\Partner;
use App\PurchaseMoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PurchaseMoneyLogController extends Controller
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
        $payType = \Request::get('payType');
//        $cardType = \Request::get('cardType');
//        $os = \Request::get('os');
//
        $partner = Partner::pluck('partnerName', 'partnerId');

        $clientType = ClientType::pluck('name', 'clientId');

        $payTypeArr = array(1 => 'Nạp thẻ', 2 => 'SMS', 3 => 'IAP');
        $matchThese = [];
        if($payType != ''){
            $matchThese['type'] = $payType;
        }

        $query = PurchaseMoneyLog::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $query->where($matchThese);
        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('purchasedTime',[$start,$end]);
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('userName')->paginate($perPage);

        return view('admin.basic.purchaseMoneyLog.index',compact('data', 'payTypeArr', 'partner', 'clientType'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
