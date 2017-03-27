<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExchangeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $phone = \Request::get('phone');
        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;
        $status = \Request::get('status');
        $requestTopup = \Request::get('requestTopup');
        $responseData = \Request::get('responseData');

        $statusArr = array('' => '---Tất cả---', 0 => "Chưa xử lý", 1 => "Thành công" ,2 => "Thất bại");

        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        $query = ExchangeAssetRequest::query();
        if($userName != ''){
            $query->where('requestUserName','LIKE','%'.$userName.'%');
        }

        if($requestTopup != ''){
            $query->where('request_topup_id','LIKE','%'.$requestTopup.'%');
        }

        if($responseData != ''){
            $query->where('responseData','LIKE','%'.$responseData.'%');
        }
        $query->where($matchThese);

        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('created_at',[$start1,$end1]);
            }
        }


        $data = $query->orderBy('requestUserName')->paginate(10);

        return view('admin.revenue.exchangeRequest.index',compact('data', 'statusArr'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}