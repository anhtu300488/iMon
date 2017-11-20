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
        $page = \Request::get('page') ? \Request::get('page') : 1;

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

//        if($fromDate != '' && $toDate != ''){
//            $start = date("Y-m-d",strtotime($fromDate));
//            $end = date("Y-m-d",strtotime($toDate));
//            $query->whereBetween('insertTime',[$start,$end]);
//        }
        if($fromDate != ''){
            $text = trim($fromDate);
            $dateArr = explode('-', $text);
            if (count($dateArr) == 2) {
                $date1 = trim($dateArr[0]);
                $day_time1 = explode(' ', $date1);
                $date1Arr = explode('/', $day_time1[0]);
                $date1Str = '';
                if (count($date1Arr) == 3) {
                    $date1Str = $date1Arr[2] . '-' . $date1Arr[1] . '-' . $date1Arr[0] . ' ' .  $day_time1[1];
                }
                $date2 = trim($dateArr[1]);
                $day_time2 = explode(' ', $date2);
                $date2Arr = explode('/', $day_time2[0]);
                $date2Str = '';
                if (count($date2Arr) == 3) {
                    $date2Str = $date2Arr[2] . '-' . $date2Arr[1] . '-' . $date2Arr[0] . ' ' .  $day_time2[1];
                }
                $query->whereBetween('insertTime', array($date1Str, $date2Str));
            }
        } else {
            $query->where("insertTime",  ">",  Date("Y-m-d"));
        }

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('insertTime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

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
