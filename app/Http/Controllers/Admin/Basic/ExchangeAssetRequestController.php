<?php

namespace App\Http\Controllers\Admin\Basic;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ExchangeAssetRequestController extends Controller
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
        $status = \Request::get('status');

        $statusArr = array('' => '---Tất cả---',0 => 'Mới insert chưa xử lý', 1 => 'SMS đã check thành công', 2 => 'Thất bại');

        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        $query = ExchangeAssetRequest::query();
        if($userName != ''){
            $query->where('requestUserName','LIKE','%'.$userName.'%');
        }
        $query->where($matchThese);
        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('purchasedTime',[$start,$end]);
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = $query->orderBy('requestUserName')->paginate($perPage);

        return view('admin.basic.exchangeAssetRequest.index',compact('data', 'statusArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
