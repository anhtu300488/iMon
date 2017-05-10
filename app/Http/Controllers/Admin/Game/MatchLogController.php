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
        $createdTime = $request->get('createdTime');
        $game = \Request::get('game');

        $gameArr = Game::where('status',1)->pluck('name', 'gameId');
        $gameArr->prepend('---Tất cả---', '');

        $list_games = Game::getListGame($game);

        $results = MatchLog::getTotalGame($game, $createdTime);

        $data = [];
        foreach ($results as $rs){
            $data[$rs->day][$rs->gameId] = $rs->total;
        }
        return view('admin.game.matchLog.index',compact('data', 'gameArr', 'list_games'));
    }
}
