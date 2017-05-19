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
//        $userId = \Request::get('userId') ? \Request::get('userId') : -1;
        $userId = \Request::get('userId');
        $timeRequest = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : explode(" - ", getToday());
        $type = \Request::get('type');
        $game = \Request::get('game');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $gameArr = Game::where('status',1)->pluck('name', 'gameId');

        $gameArr->prepend('Hệ thống', -1);
        $gameArr->prepend('---Tất cả---', '');

        $typeArr = array('' => '---Tất cả---', 1 => "Mon");

        $query = MoneyLog::query();

        if($game != ''){
            $query->where('gameId','=',$game);
        }
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        if($userId != ''){
            $query->where('userId','=',$userId);
        }
        if($type != ''){
            if($type == 1){
                $query->where('changeCash','!=', 0);
            }
            elseif($type == 2){
                $query->where('changeCash','=', 0);
            }
        }

//        $query->where('gameId','!=', -1);

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
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('insertedTime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.revenue.historyMoney.index',compact('data', 'typeArr', 'gameArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
