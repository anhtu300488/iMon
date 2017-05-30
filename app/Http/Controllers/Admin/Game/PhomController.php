<?php

namespace App\Http\Controllers\Admin\Game;

use App\MatchLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PhomController extends Controller
{
    public function index(Request $request){
        $typeArr = array('' => '---Tất cả---', 1 => 'Ken', 2 => 'Xu');

        $roomId = \Request::get('roomId');
        $matchIndex = \Request::get('matchIndex');
        $type = \Request::get('type');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $userId = \Request::get('userId');

        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = MatchLog::query()->where("gameId", "=", 4);
        if($roomId != ''){
            $query->where('roomId','LIKE','%'.$roomId.'%');
        }

        if($matchIndex != ''){
            $query->where('matchIndex','LIKE','%'.$matchIndex.'%');
        }

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('createdTime',[$start,$end]);
        }
        if($userId != ''){
            $query->where('description','LIKE','%'.$userId.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('createdtime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.game.phom.index',compact('data', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
