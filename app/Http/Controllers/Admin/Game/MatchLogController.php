<?php

namespace App\Http\Controllers\Admin\Game;

use App\Game;
use App\MatchLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $data = $query->orderBy('createdTime', 'desc')->paginate(10);

        return view('admin.game.matchLog.index',compact('data', 'game'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
