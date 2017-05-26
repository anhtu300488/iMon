<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Game;
use App\OnlineLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CCUController extends Controller
{
    public function index(Request $request){
        $timeArr = array('' => 'Theo ngày',6 => "6 tiếng" , 1 => "1 tiếng" , 2 => "2 tiếng", 24 =>"Trong ngày");

        $insertedtime = $request->get('insertedtime');
        $option = $request->get('option');
        $online_logs = OnlineLog::getOnlineLog($insertedtime, $option)->toArray();
        $arr_log = array();
//        if(count($online_logs) > 0){
            foreach($online_logs as $i => $log){
                $arr_data =  (array)  json_decode($log["peakData"]);
                $sum  = array_sum($arr_data);
                $arr_log[$log["insertedTime"]] = array(json_decode($log["peakData"])->total, $sum - $arr_data["total"] - array_values($arr_data)[0]);

            }
            $current_online = OnlineLog::getOnlineLog($insertedtime, $option)->toArray();
            $current_time_log = json_decode($current_online[0]["peakData"]);
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
//        } else {
//            $arr_game["Người chơi"] = "0/0";
//        }

//        var_dump($arr_log);die;

        return view('admin.revenue.ccu.index', compact('timeArr','arr_game','arr_log'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function statistic($fromDate){
        $fromDate = str_replace('-', '/', $fromDate);
        if(date("Y-m-d",strtotime($fromDate)) == date("Y-m-d",strtotime(Carbon::now()))){
            $fromDate = Carbon::now();
        } else {
            $fromDate = date("Y-m-d 23:59:59",strtotime($fromDate));
        }
//        $fromDate = Carbon::now();
        $insertedtime = date("Y-m-d H:i:s",strtotime($fromDate));
        $arr_log = array();
        $online_logs = OnlineLog::getOnlineLogHour($insertedtime);
        foreach($online_logs as $i => $log){
            $arr_log[date("H:i",strtotime($log["insertedTime"]))][0] = json_decode($log["peakData"])->total ? json_decode($log["peakData"])->total :0;

        }

        $insertedtime2 = date("Y-m-d H:i:s",strtotime( $fromDate.' -1 days' ));
        $online_logs1 = OnlineLog::getOnlineLogHour($insertedtime2);
        foreach($online_logs1 as $i => $log){
            $arr_log[date("H:i",strtotime($log["insertedTime"]))][1] = json_decode($log["peakData"])->total ? json_decode($log["peakData"])->total :0;

        }
        return $arr_log;
    }
}
