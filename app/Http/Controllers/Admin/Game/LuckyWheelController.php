<?php

namespace App\Http\Controllers\Admin\Game;

use App\LuckyWheelChance;
use App\LuckyWheelItem;
use App\LuckyWheelLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('time',[$start,$end]);
        }
        $data = $query->orderBy('time', 'desc')->paginate(10);

        $list_by_round = LuckyWheelLog::getSumKenByRound($userId, $roundItem, $description, $fromDate, $toDate);

        return view('admin.game.luckyWheel.log',compact('data', 'item', 'list_by_round'))->with('i', ($request->input('page', 1) - 1) * 10);
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
        $data = $query->orderBy('itemId', 'desc')->paginate(10);

        return view('admin.game.luckyWheel.item',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
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

        $data = $query->orderBy('chanceId', 'desc')->paginate(10);

        return view('admin.game.luckyWheel.chance',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
