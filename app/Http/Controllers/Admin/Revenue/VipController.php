<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ExchangeAssetRequest;
use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Cp;

class VipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : explode(" - ", get7Day());
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;
        $query = DB::table('user as a');
        $query->join('purchase_money_log', function($join)
        {
            $join->on('purchase_money_log.userId', '=', 'a.userId');

        });
        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21,22]);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');

        $game_select = \Request::get('list_games');
        $partner->prepend('---Tất cả---', '');
        $query->select(DB::raw("COUNT(purchase_money_log.userId) numberExchange"), DB::raw("SUM(purchase_money_log.parValue) sumMoney"), 'a.*' );
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'purchase_money_log.userId');

        });
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('purchase_money_log.purchasedTime',[$start1,$end1]);
            }
        }

//        $query->where('a.status','=',1);

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $data = $query->groupBy("purchase_money_log.userId")->orderBy(DB::raw("a.totalMoneyCharged"), 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

//        var_dump($data);die;

        return view('admin.revenue.vip.index',compact('data', 'partner'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function downloadExcel(Request $request){

        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : explode(" - ", get7Day());
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;
        $query = UserReg::query();
        $query->join('purchase_money_log', function($join)
        {
            $join->on('purchase_money_log.userId', '=', 'user.userId');

        });

        $query->select("user.userId", "user.userName","user.displayName", "user.cp","user.cash", DB::raw("COUNT(purchase_money_log.userId) numberExchange"), DB::raw("SUM(purchase_money_log.parValue) sumMoney") , "user.totalMoneyCharged", "user.totalMoneyExchanged", "user.lastLoginTime", "user.registedTime", "user.device", "user.verifiedPhone" );
        if($cp != null){
            $query->where('user.cp','=', $cp);
        }
        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('purchase_money_log.purchasedTime',[$start1,$end1]);
            }
        }

        $results = $query->groupBy("purchase_money_log.userId")->orderBy(DB::raw("user.totalMoneyCharged"), 'desc')->get();

        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = $result->toArray();
            $data[$k]["userName"] = str_replace('=','\=',$result->userName);
            $data[$k]["displayName"] = str_replace('=','\=',$result->displayName);

        }

        // Generate and return the spreadsheet
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '-1');
        return \Maatwebsite\Excel\Facades\Excel::create('vip', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $headings = array('User ID','Tên đăng nhập', 'Tên hiển thị','Cp','Số mon hiện tại','Số lần nạp','Số tiền nạp','Tổng tiền nạp', 'Tổng tiền đổi', 'Last login', 'Thời gian đăng ký', 'Mã thiết bị', 'Số điện thoại kích hoạt');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');

    }
}
