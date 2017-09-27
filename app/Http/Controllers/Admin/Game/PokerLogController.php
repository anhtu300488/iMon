<?php

namespace App\Http\Controllers\Admin\Game;
use Carbon\Carbon;
use App\MatchLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PokerLogController extends Controller
{
    public function log(Request $request){
        $arr_type = array("" => "---Tất cả---", 100 => "100", 1000 => "1000", 10000 => "10000" );
        $arr_card = array("" => "---Tất cả---" , 54 => "Nổ hũ", 57 => "Thùng phá sảnh", 58 => "Tứ quý chi đầu",
            59 => "Cù lũ", 60 => "Thùng", 61 => "Sảnh", 62 => "Xám",
            63 => "Thú", 64 => "Đôi J trở lên", 65 => "Mậu thầu");

        $roomId = \Request::get('roomId');
        $logIndex = \Request::get('logIndex');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $userId = \Request::get('userId');

        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = MatchLog::query()->where("gameId", "=", 3);
        if($roomId != ''){
            $query->where('roomId','LIKE','%'.$roomId.'%');
        }

        if($logIndex != ''){
            $query->where('matchLogId','LIKE','%'.$logIndex.'%');
        }

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('createdTime',[$start,$end]);
        } else {
            $query->where("createdTime",  ">",  Date("Y-m-d", strtotime(Carbon::now().' -7 days') ));

        }
        if($userId != ''){
            $query->where('description','LIKE','%'.$userId.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('createdtime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.game.poker.index',compact('data', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);

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
