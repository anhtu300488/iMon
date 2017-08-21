<?php

namespace App\Http\Controllers\Admin\Game;

use App\MatchLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class BaCayController extends Controller
{
    public function index(Request $request){
        $typeArr = array('' => '---Tất cả---', 1 => 'Ken', 2 => 'Xu');

        $roomId = \Request::get('roomId');
        $matchIndex = \Request::get('matchIndex');
        $type = \Request::get('type');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $userId = \Request::get('userId');


        $query = MatchLog::query()->where("gameId", "=", 1);
        if($roomId != ''){
            $query->where('roomId','LIKE','%'.$roomId.'%');
        }

        if($matchIndex != ''){
            $query->where('matchLogId','LIKE','%'.$matchIndex.'%');
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
        $data = $query->orderBy('createdtime', 'desc')->paginate($perPage);

        return view('admin.game.bacay.index',compact('data', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
