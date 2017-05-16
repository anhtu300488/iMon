<?php

namespace App\Http\Controllers\Admin\Tool;

use App\CrashTableAlarm;
use App\Game;
use App\RoomToKill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class CrashTableAlarmController extends Controller
{
    public function index(Request $request){
        $roomIndex = \Request::get('roomIndex');
        $game = \Request::get('game');

        $gameArr = Game::where('status',1)->pluck('name', 'gameId');

        $gameArr->prepend('---Tất cả---', '');

        $query = CrashTableAlarm::query();

        if($game != ''){
            $query->where('gameId','=',$game);
        }
        if($roomIndex != ''){
            $query->where('roomIndex','=',$roomIndex);
        }

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('insertTime', 'desc')->paginate($perPage);

        return view('admin.tool.crashTableAlarm.index',compact('data', 'gameArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);

    }

    public function update($id){
        if(Input::get('alarmOff')) {
            CrashTableAlarm::where('crashId', $id)->update(['isAlarm' => 0]);
            return redirect()->route('crashTableAlarm.index')
                ->with('message','Tắt cảnh báo thành công');
        } elseif(Input::get('deleteRoom')) {
            $crashTableData = CrashTableAlarm::find($id);
            CrashTableAlarm::where('crashId', $id)->update(['isAlarm' => 0]);
            $data = array();
            $arr = array('gameId'=> $crashTableData->gameId, 'roomIndex'=> $crashTableData->roomIndex, 'createdDate'=> $crashTableData->insertTime, 'modifiedDate' => $crashTableData->updateTime, 'active' => 1);
            array_push($data, $arr);

            RoomToKill::insert($data);

            return redirect()->route('crashTableAlarm.index')
                ->with('message','Xóa phòng thành công');
        }

    }

}
