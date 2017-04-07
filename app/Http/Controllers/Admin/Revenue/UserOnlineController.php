<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ClientType;
use App\Game;
use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = \Request::get('userId');
        $game = \Request::get('gameArr');
        $clientId = \Request::get('clientType');

        $gameArr = Game::pluck('name', 'gameId');

        $gameArr->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $matchThese = [];
        if($game != ''){
            $matchThese['currentGameId'] = $game;
        }

        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($clientId != ''){
            $matchThese['clientId'] = $clientId;
        }

        $query = UserReg::query();

        $query->where($matchThese)->where('currentGameId', '>', 0);

        $data = $query->orderBy('cash','desc')->paginate(10);

        return view('admin.revenue.userOnline.index',compact('data', 'gameArr', 'clientType'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
