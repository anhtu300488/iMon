<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

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
        $displayName = \Request::get('displayName');
        $userId = \Request::get('userId');
        $phone = \Request::get('phone');
        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;
        $status = \Request::get('status');
        $requestTopup = \Request::get('requestTopup');
        $responseData = \Request::get('responseData');

        $statusArr = array('' => '---Tất cả---', 3 => "Chưa xử lý", 1 => "Thành công" , 2 => "Thất bại", -1 => "Từ chối");

        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        $query = ExchangeAssetRequest::query();
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'requestUserId');

        });
        if($userId != ''){
            $query->where('user.userId','=',$userId);
        }
        if($userName != ''){
            $query->where('requestUserName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
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

//        $query->where('status', '!=', -1);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('created_at', 'desc')->paginate($perPage);
        $purchase_arr = array();
        $purchase_moneys = ExchangeAssetRequest::getTotalRevenueByDate($timeRequest);
        foreach ($purchase_moneys as $index => $purchase_money){
            $purchase_arr[$purchase_money->purchase_date] = $purchase_money->sum_money;
        }


        return view('admin.revenue.exchangeRequest.index',compact('data', 'statusArr', 'purchase_arr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function update($id){
        ExchangeAssetRequest::where('requestId', $id)->update(['status' => 2, 'description' => 'handler']);
        return redirect()->route('revenue.exchangeRequest')
            ->with('message','Updated Successfully');
    }

    public function delete(Request $request){
        $this->validate($request, [
            'description' => 'required|max:1000',
            'exchangeId' => 'required'
        ]);
        $id = Input::get('exchangeId');
        $description = Input::get('description');
        ExchangeAssetRequest::where('requestId', $id)->update(['status' => 4, 'description' => $description]);
        return redirect()->route('revenue.exchangeRequest')
            ->with('message','Updated Successfully');
    }
}
