<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Agent;
use App\CashTransferLog;
use App\Cp;
use App\ExchangeAssetRequest;
use App\Game;
use App\UserReg;
use App\UserStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : explode(" - ", get7Day());
        $status = \Request::get('status') ? \Request::get('status') : 3;
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;
    //    $partner = Cp::where('cpId','!=', 1)->pluck('cpName', 'cpId');

        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');

        $partner->prepend('---Tất cả---', '');
        $statusArr = array(3 => "Chưa xử lý", 1 => "Thành công" , 2 => "Thất bại", -1 => "Từ chối", 5 => "Đang kiểm tra", -2 => '---Tất cả---');

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

        if($status != -2){
            $query->where('exchange_asset_request.status','=',$status);
        }

        if($cp != null){
            $query->where('user.cp','=',$cp);
        }
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
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
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('exchange_asset_request.created_at', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);
        $purchase_arr = array();
        $purchase_moneys = ExchangeAssetRequest::getTotalRevenueByDate($timeRequest, $cp);
        foreach ($purchase_moneys as $index => $purchase_money){
            $purchase_arr[$purchase_money->purchase_date] = $purchase_money->sum_money;
        }


        return view('admin.revenue.exchangeRequest.index',compact('data', 'statusArr', 'purchase_arr', 'partner'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function update($id){
        //check which submit was clicked on
        $status = 5;
        if(Input::get('checking')) {
            $status = 5; //if login then use this method
        } elseif(Input::get('reload')) {
            $status = 2; //if register then use this method
        }
        $admin = Auth::user()->id;
        ExchangeAssetRequest::where('requestId', $id)->update(['status' => $status, 'description' => 'handler', 'admin_id' => $admin]);
        return redirect()->route('revenue.exchangeRequest')
            ->with('message','Updated Successfully');
    }

    public function delete(Request $request){
        $this->validate($request, [
            'description' => 'required|max:1000',
            'exchangeId' => 'required',
            'type' => 'required',
        ]);
        $id = Input::get('exchangeId');
        $description = Input::get('description');
        $type = Input::get('type');
        if($type == 1){
            $status = 2;
        } elseif ($type == 2){
            $status = 4;
        }
        $admin = Auth::user()->id;
        ExchangeAssetRequest::where('requestId', $id)->update(['status' => $status, 'description' => $description, 'admin_id' => $admin]);
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
            $sum = array_sum($total) ? array_sum($total) : 0;
            $data[$rs['gameId']] = array($rs['sum_winningMatch'] , $rs['sum_drawMatch'], $rs['sum_losingMatch'], $sum);
        }
        $list_games = Game::getListGame($game = null);

        $html = "<table class='table table-striped table-bordered table-hover no-margin-bottom no-border-top'>
                <thead><tr>
                <th>Tên Game</th>";
        foreach ($list_games as $valgame){
            $html = $html . "<th>".$valgame['name']."</th>";
        }

        $html = $html . "</tr></thead><tbody>";
        $html = $html . "<tr><td>Tổng số ván chơi</td>";
        foreach ($list_games as $valgame){
            $value = isset($data[$valgame['gameId']][3]) ? $data[$valgame['gameId']][3] : 0;
            $html = $html . "<td>".$value."</td>";
        }

        $html = $html . "</tr><tr><td>Tổng số ván thắng</td>";
        foreach ($list_games as $valgame){
            $value = isset($data[$valgame['gameId']][0]) ? $data[$valgame['gameId']][0] : 0;
            $html = $html . "<td>".$value."</td>";
        }

        $html = $html . "</tr><tr><td>Tổng số ván hòa</td>";
        foreach ($list_games as $valgame){
            $value = isset($data[$valgame['gameId']][1]) ? $data[$valgame['gameId']][1] : 0;
            $html = $html . "<td>".$value."</td>";
        }

        $html = $html . "</tr><tr><td>Tổng số ván thua</td>";
        foreach ($list_games as $valgame){
            $value = isset($data[$valgame['gameId']][2]) ? $data[$valgame['gameId']][2] : 0;
            $html = $html . "<td>".$value."</td>";
        }

        $html = $html . "</tr></tbody></table>";

        return $html;
    }

    public function downloadExcel(Request $request){
        $userName = \Request::get('userName');
        $displayName = \Request::get('displayName');
        $userId = \Request::get('userId');
        $phone = \Request::get('phone');
        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : explode(" - ", get7Day());
        $status = \Request::get('status') ? \Request::get('status') : 3;

        $statusArr = array(3 => "Chưa xử lý", 1 => "Thành công" , 2 => "Thất bại", -1 => "Từ chối", 5 => "Đang kiểm tra", -2 => '---Tất cả---');

        $query = ExchangeAssetRequest::query()->select("userId","userName", DB::raw('user.displayName as displayName'), DB::raw('user.totalMoneyCharged as totalMoneyCharged'), "totalCash", "totalParValue", "responseData", DB::raw('exchange_asset_request.status as status') , "created_at");
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

        if($status != -2){
            $query->where('exchange_asset_request.status','=',$status);
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

        $results = $query->orderBy('exchange_asset_request.created_at', 'desc')->get();
//        var_dump($results);die;
        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = $result->toArray();
            $data[$k]["responseData"] = getSerial($result->responseData);
            $data[$k]["status"] = $statusArr[$result->status];

        }
        // Generate and return the spreadsheet
        ini_set('max_execution_time', 360);
        ini_set('memory_limit', '-1');
        return \Maatwebsite\Excel\Facades\Excel::create('exchange_asset', function($excel) use ($data) {
            $excel->sheet('exchange_asset', function($sheet) use ($data)
            {
                $headings = array('User ID', 'Tên hiển thị','Tên đăng nhập','Tổng tiền đã nạp','Total cash', 'Giá trị thẻ', 'Seri thẻ', 'Trạng thái', 'Thời gian tạo');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }

    public function getMoneyExchange($id){
        $timeRequest = explode(" - ", getToday());

        $query = DB::table('user as a');
        $query->join('exchange_asset_request', function($join)
        {
            $join->on('exchange_asset_request.requestUserId', '=', 'a.userId');

        });
        $query->select(DB::raw("SUM(exchange_asset_request.totalParValue) sumMoney"));

        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('exchange_asset_request.created_at',[$start1,$end1]);
            }
        }
        if($id != ''){
            $query->where('a.userId','=', $id);
        }

        $query->where('exchange_asset_request.status', '=', 1);

        $results = $query->get()->toArray();
        foreach ($results as $rs){
            $data = $rs->sumMoney;
        }


        return number_format($data);
    }

    public function getMoneyTransfer($id){
        return CashTransferLog::getMoneyTransfer($id);
    }

    public function getMoneyReceived($id){
        return CashTransferLog::getMoneyReceived($id);
    }

}
