<?php

namespace App\Http\Controllers\Admin\Users;

use App\Game;
use App\UserReg;
use App\UserStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TopGameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $game = \Request::get('game') ? \Request::get('game') : 1;
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;

        $gameArr = Game::pluck('name', 'gameId')->toArray();

        $query = DB::table('user_statistic as a')->select(DB::raw('COUNT(DISTINCT a.userId) as total'), 'a.userName', 'a.gameId')->where('a.period', '=', 0)->whereIn('a.gameId', array_keys((array) $gameArr));

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('a.createdTime',[$start,$end]);
            }
        }

        if($game != ''){
            $query->where('a.gameId', '=', $game);
        }

        $data = $query->groupBy('a.userName', 'a.gameId')->orderBy(DB::raw('COUNT(DISTINCT a.userId)'),'desc')->paginate(10);
//        var_dump($data);die;

        return view('admin.users.topGame.index',compact('data', 'gameArr'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
