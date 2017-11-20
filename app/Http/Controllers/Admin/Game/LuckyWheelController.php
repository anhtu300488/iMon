<?php

namespace App\Http\Controllers\Admin\Game;

use App\LuckyWheelChance;
use App\LuckyWheelItem;
use App\LuckyWheelLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class LuckyWheelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function log(Request $request)
    {
        $userId = \Request::get('userId');
        $roundItem = \Request::get('item');
        $description = \Request::get('description');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $item = LuckyWheelItem::pluck('itemName', 'itemId');

        $item->prepend('---Tất cả---', '');

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($roundItem != ''){
            $matchThese['round1_item'] = $roundItem;
        }

        $query = LuckyWheelLog::query();
        if($description != ''){
            $query->where('description','LIKE','%'.$description.'%');
        }

        $query->where($matchThese);

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
                $query->whereBetween('time', array($date1Str, $date2Str));
            }
        } else {
            $query->where("time",  ">",  Date("Y-m-d"));
        }


        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('logId', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        $list_by_round = LuckyWheelLog::getSumKenByRound($userId, $roundItem, $description, $fromDate, $toDate);

        return view('admin.game.luckyWheel.log',compact('data', 'item', 'list_by_round'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function item(Request $request)
    {
        $itemName = \Request::get('itemName');

        $query = LuckyWheelItem::query();
        if($itemName != ''){
            $query->where('itemName','LIKE','%'.$itemName.'%');
        }
        $perPage = Config::get('app_per_page');
        $data = $query->orderBy('itemId', 'desc')->paginate($perPage);

        return view('admin.game.luckyWheel.item',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chance(Request $request)
    {
        $userId = \Request::get('userId');
        $chanceNumber = \Request::get('chanceNumber');

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($chanceNumber != ''){
            $matchThese['chance_number'] = $chanceNumber;
        }

        $query = LuckyWheelChance::query();


        $query->where($matchThese);
        $perPage = Config::get('app_per_page');
        $data = $query->orderBy('chanceId', 'desc')->paginate($perPage);

        return view('admin.game.luckyWheel.chance',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
