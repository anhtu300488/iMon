<?php

namespace App\Http\Controllers\Admin\Game;

use App\Game;
use App\MatchLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class MatchLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roomId = \Request::get('roomId');
        $matchIndex = \Request::get('matchIndex');
        $gameId = \Request::get('gameId');

        $game = Game::pluck('name', 'gameId');

        $matchThese = [];
        if($roomId != ''){
            $matchThese['roomId'] = $roomId;
        }

        if($matchIndex != ''){
            $matchThese['matchIndex'] = $matchIndex;
        }

        if($gameId != ''){
            $matchThese['gameId'] = $gameId;
        }

        $query = MatchLog::query();

        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('createdTime', 'desc')->paginate($perPage);

//        var_dump($data);die;
        foreach ($data as $k => $v){
            if($v->gameId){

            }
        }
        return view('admin.game.matchLog.index',compact('data', 'game'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
