<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Game;
use App\MoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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
        $displayName = \Request::get('displayName');

        $gameArr = Game::where('status',1)->pluck('name', 'gameId');

        $gameArr->prepend('---Tất cả---', '');

        $typeArr = array('' => '---Tất cả---', 1 => "Mon");

        $query = MoneyLog::query();
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'money_log.userId');

        });
        $matchThese = [];
        if($game != ''){
            $matchThese['gameId'] = $game;
        }
        if($userName != ''){
            $query->where('user.userName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
        }
        if($userId != ''){
            $query->where('user.userId','=',$userId);
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

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('insertedTime', 'desc')->paginate($perPage);

        return view('admin.revenue.historyMoney.index',compact('data', 'typeArr', 'gameArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
