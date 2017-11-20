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

        $fromDate = \Request::get('fromDate');
        $userId = \Request::get('userId');

        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = MatchLog::query()->where("gameId", "=", 3);
        
        $sessionId = \Request::get('sessionId');
        if($sessionId != ''){
            $query->where('sessionId','=', $sessionId );
        }

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
                $query->whereBetween('createdTime', array($date1Str, $date2Str));
            }
        } else {
            $query->where("createdTime",  ">",  Date("Y-m-d"));
        }
        if($userId != ''){
            $query->where('description','LIKE','%'.$userId.'%');
        } else {
            if($sessionId == ''){
                $query->where('matchLogId','=',1);
            }
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('matchLogId', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

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
