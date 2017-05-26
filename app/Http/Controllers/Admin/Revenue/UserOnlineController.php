<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ClientType;
use App\Game;
use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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
        $userName = \Request::get('userName');
        $displayName = \Request::get('displayName');
        $game = \Request::get('gameArr');
        $clientId = \Request::get('clientType');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $gameArr = Game::where('status',1)->pluck('name', 'gameId');

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
        if($userName != ''){
            $query->where('userName','LIKE', '%'.$userName.'%');
        }

        if($displayName != ''){
            $query->where('displayName','LIKE', '%'.$displayName.'%');
        }

        $query->where($matchThese)->where('currentGameId', '>', 0);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('cash','desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.revenue.userOnline.index',compact('data', 'gameArr', 'clientType'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
