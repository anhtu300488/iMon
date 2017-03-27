<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Game;
use App\MoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MoneyHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $userId = \Request::get('userId');
        $timeRequest = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;
        $type = \Request::get('type');
        $game = \Request::get('game');

        $gameArr = Game::pluck('name', 'gameId');

        $gameArr->prepend('---Tất cả---', '');

        $typeArr = array('' => '---Tất cả---', 1 => "Ken" ,2 => "Xu");

        $matchThese = [];
        if($game != ''){
            $matchThese['game'] = $game;
        }

        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        $query = MoneyLog::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($type != ''){
            if($type == 1){
                $query->where('changeCash','!=', 0);
            }
            elseif($type == 2){
                $query->where('changeCash','=', 0);
            }
        }

        $query->where($matchThese);

        if($timeRequest != ''){
            $startPlayGame = $timeRequest[0];

            $endPlayGame = $timeRequest[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('insertedTime',[$start1,$end1]);
            }
        }


        $data = $query->orderBy('insertedTime')->paginate(10);

        return view('admin.revenue.historyMoney.index',compact('data', 'typeArr', 'gameArr'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
