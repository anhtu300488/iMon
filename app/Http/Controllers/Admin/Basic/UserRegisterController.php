<?php

namespace App\Http\Controllers\Admin\Basic;

use App\ClientType;
use App\Partner;
use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class UserRegisterController extends Controller
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
        $device = \Request::get('device');
        $os = \Request::get('clientType');
        $ip = \Request::get('ip');

        $partner = Partner::pluck('partnerName', 'partnerId');

        $partner->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $matchThese = [];
        if($os != ''){
            $matchThese['clientId'] = $os;
        }

        $query = UserReg::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($device != ''){
            $query->where('device','LIKE','%'.$device.'%');
        }

        if($ip != ''){
            $query->where('ip','LIKE','%'.$ip.'%');
        }

        $query->where($matchThese);

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('registedTime',[$start,$end]);
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = $query->orderBy('registedTime', 'desc')->paginate($perPage);

        return view('admin.basic.userReg.index',compact('data', 'partner', 'clientType'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
