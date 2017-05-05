<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use App\Game;
use App\UserReg;
use App\UserStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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
        $status = \Request::get('status') ? \Request::get('status') : 3;
        $requestTopup = \Request::get('requestTopup');
        $responseData = \Request::get('responseData');

        $statusArr = array(3 => "Chưa xử lý", 1 => "Thành công" , 2 => "Thất bại", -1 => "Từ chối", -2 => '---Tất cả---');

        $query = ExchangeAssetRequest::query()->select('*', DB::raw('exchange_asset_request.status as status'), DB::raw('user.displayName as displayName'));
        $query->leftjoin('user', function($join)
        {
            $join->on('user.userId', '=', 'exchange_asset_request.requestUserId');

        });
        if($userId != ''){
            $query->where('user.userId','=',$userId);
        }
        if($userName != ''){
            $query->where('exchange_asset_request.requestUserName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
        }
        if($requestTopup != ''){
            $query->where('exchange_asset_request.request_topup_id','LIKE','%'.$requestTopup.'%');
        }

        if($status != -2){
            $query->where('exchange_asset_request.status','=',$status);
        }

        if($responseData != ''){
            $query->where('exchange_asset_request.responseData','LIKE','%'.$responseData.'%');
        }

        $query->where('user.status', '=', 1);

        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('exchange_asset_request.created_at',[$start1,$end1]);
            }
        }

//        $query->where('status', '!=', -1);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('exchange_asset_request.created_at', 'desc')->paginate($perPage);
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

    public function getMatchLog($id){
        $query = UserStatistic::query();
        $query->select(DB::raw("gameId"), DB::raw('SUM(winningMatch) as sum_winningMatch'), DB::raw('SUM(drawMatch) as sum_drawMatch'), DB::raw('SUM(losingMatch) as sum_losingMatch') );
        $query->where('period', '=', 0);
        if($id != ''){
            $query->where('userId','=', $id);
        }
        $results = $query->groupBy("gameId")->get()->toArray();
        $data = [];

        foreach ($results as $rs){
            $total = array($rs['sum_winningMatch'] , $rs['sum_drawMatch'], $rs['sum_losingMatch']);
            $data[$rs['gameId']] = array_sum($total) ? array_sum($total) : 0;
        }
        $list_games = Game::getListGame($game = null);

        $html = "<table class='table table-striped table-bordered table-hover no-margin-bottom no-border-top'>
                <thead><tr>";
        foreach ($list_games as $valgame){
            $html = $html . "<th>".$valgame['name']."</th>";
        }

        $html = $html . "</tr></thead><tbody>";
        foreach ($list_games as $valgame){
            $value = isset($data[$valgame['gameId']]) ? $data[$valgame['gameId']] : 0;
            $html = $html . "<td>".$value."</td>";
        }

        $html = $html . "</tbody></table>";

        return $html;
    }
}
