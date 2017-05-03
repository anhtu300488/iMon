<?php

namespace App\Http\Controllers\Admin\Game;

use App\MiniPokerLog;
use App\MiniPokerRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class MiniPokerLogController extends Controller
{
    public function log(Request $request){

        $userId = \Request::get('userId');
        $type = \Request::get('type');
        $card = \Request::get('card');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');

        $arr_type = array("" => "---Tất cả---", 100 => "100", 1000 => "1000", 10000 => "10000" );
        $arr_card = array("" => "---Tất cả---" , 54 => "Nổ hũ", 57 => "Thùng phá sảnh", 58 => "Tứ quý chi đầu",
            59 => "Cù lũ", 60 => "Thùng", 61 => "Sảnh", 62 => "Xám",
            63 => "Thú", 64 => "Đôi J trở lên", 65 => "Mậu thầu");

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($type != ''){
            $matchThese['betMoney'] = $type;
        }

        if($card != ''){
            $matchThese['cards'] = $card;
        }

        $query = MiniPokerLog::query();

        $query->where($matchThese);

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('insertTime',[$start,$end]);
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('insertTime', 'desc')->paginate($perPage);

        $list_by_round = MiniPokerLog::getSumKenByRound($userId, $type, $card, $fromDate, $toDate);

        $sumByFilter = MiniPokerLog::getSumByFilter($userId, $type, $card, $fromDate, $toDate);

        return view('admin.game.miniPoker.log',compact('data', 'list_by_round', 'arr_type', 'arr_card', 'sumByFilter'))->with('i', ($request->input('page', 1) - 1) * $perPage);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request)
    {
        $itemName = \Request::get('name');
        $status = \Request::get('status');

        $statusArr = array('' => '---Tất cả---', 0 => 'Không hoạt động', 1 => 'Hoạt động');

        $query = MiniPokerRate::query();
        if($itemName != ''){
            $query->where('name','LIKE','%'.$itemName.'%');
        }
        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = $query->orderBy('name', 'desc')->paginate($perPage);

        return view('admin.game.miniPoker.rate',compact('data', 'statusArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
