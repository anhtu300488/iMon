<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Game;
use App\OnlineLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CCUController extends Controller
{
    public function index(Request $request){
        $timeArr = array('' => 'Theo ngày',6 => "6 tiếng" , 1 => "1 tiếng" , 2 => "2 tiếng", 24 =>"Trong ngày");

        $insertedtime = $request->get('insertedtime');
//        $option = $request->get('option');
        $option = null;
        $online_logs = OnlineLog::getOnlineLog($insertedtime, $option)->toArray();
//        var_dump($online_logs);die;
        $arr_log = array();
        if(count($online_logs) > 0){
            foreach($online_logs as $i => $log){
                $arr_data =  (array)  json_decode($log["peakData"]);
                $sum  = array_sum($arr_data);
                $arr_log[$log["insertedTime"]] = array(json_decode($log["peakData"])->total, $sum - $arr_data["total"] - array_values($arr_data)[0]);

            }

            $current_time_log = json_decode($online_logs[0]["peakData"]);
            $current_time_log = json_decode(json_encode($current_time_log), true);
            $list_game  = Game::getListGame()->toArray();
            $arr_game = array();
            $arr_game["Người chơi"] = $current_time_log['total'];
            $num_player = 0 ;
            foreach($list_game as $i => $game){
                if($current_time_log[$game["gameId"]] != 0){
                    $arr_game[$game["name"]] =  $current_time_log[$game["gameId"]];
                    $num_player += $arr_game[$game["name"]];
                }
            }
            $arr_game["Người chơi"] = $num_player . "/" . $current_time_log['total'];
        } else {
            $arr_game["Người chơi"] = "0/0";
        }

        return view('admin.revenue.ccu.index', compact('timeArr','arr_game','arr_log'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
