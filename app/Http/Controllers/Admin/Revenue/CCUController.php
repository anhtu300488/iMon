<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Cp;
use App\Game;
use App\OnlineLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CCUController extends Controller
{
    public function index(Request $request){
        $timeArr = array('' => 'Theo ngày',6 => "6 tiếng" , 1 => "1 tiếng" , 2 => "2 tiếng", 24 =>"Trong ngày");

        $insertedtime = $request->get('insertedtime');
        $option = $request->get('option');
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;

        // $partner = Cp::where('cpId','!=', 1)->pluck('cpName', 'cpId');
        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21,22]);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');

        $game_select = \Request::get('list_games');
        $partner->prepend('---Tất cả---', '');
        $list_games = Game::where('status','=', 1);
        $list_games = $list_games->pluck('name', 'gameId');
        $list_games->prepend('---Tất cả---', '');

        $online_logs = OnlineLog::getOnlineLog($insertedtime, $option, $cp)->toArray();
        $arr_log = array();
//        if(count($online_logs) > 0){
            foreach($online_logs as $i => $log){
                $arr_data =  (array)  json_decode($log["peakData"]);
                $sum  = array_sum($arr_data);
                $par = 0;
                $arrKey = array_keys($arr_data);
                if(in_array('0', $arrKey) == true){
                    $par = array_search('0', $arrKey);
                }
                if($game_select > 0){
                    $online_game_number = 0;
                    foreach ($arr_data as $key => $value) {
                        if($key == $game_select ){
                            $online_game_number = $value;
                            break;
                        }
                    }
                    $arr_log[$log["insertedTime"]] = array(json_decode($log["peakData"])->total, $online_game_number);

                } else {
                    $arr_log[$log["insertedTime"]] = array(json_decode($log["peakData"])->total, $sum - $arr_data["total"] - array_values($arr_data)[$par] );
                }

            }
            $current_online = OnlineLog::getOnlineLog($insertedtime, $option, $cp)->toArray();
        if(isset($current_online[0])){
            $current_time_log = json_decode($current_online[0]["peakData"]);
            $current_time_log = json_decode(json_encode($current_time_log), true);
            $list_game  = Game::getListGame()->toArray();
            $arr_game = array();
            $arr_game["Người chơi"] = $current_time_log['total'];
            $num_player = 0 ;

            foreach($list_game as $i => $game){
//                var_dump($current_time_log);die;
                if(isset($current_time_log[$game["gameId"]]) && $current_time_log[$game["gameId"]] != 0){
                    $arr_game[$game["name"]] =  $current_time_log[$game["gameId"]];
                    $num_player += $arr_game[$game["name"]];
                }
            }
            $arr_game["Người chơi"] = $num_player . "/" . $current_time_log['total'];
        }

//        } else {
//            $arr_game["Người chơi"] = "0/0";
//        }

        return view('admin.revenue.ccu.index', compact('timeArr','arr_game','arr_log', 'partner', 'list_games'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function statistic($gameId,$partner){
//         $fromDate = str_replace('-', '/', $fromDate);
//         if(date("Y-m-d",strtotime($fromDate)) == date("Y-m-d",strtotime(Carbon::now()))){
//             $fromDate = Carbon::now();
//         } else {
//             $fromDate = date("Y-m-d 23:59:59",strtotime($fromDate));
//         }
//         var_dump(strtotime($fromDate));die;
        $cp = $partner != "1" ? $partner : Auth::user()->cp_id;

// //        $fromDate = Carbon::now();
//         $insertedtime = date("Y-m-d H:i:s",strtotime($fromDate));
         $arr_log = array();
//                 var_dump( $insertedtime );die;
// var_dump(Date("Y-m-d", strtotime(Carbon::now().' -1 days')));die;
     $online_logs1 = OnlineLog::getOnlineLogHour(Date("Y-m-d", strtotime(Carbon::now().' -1 days')),$cp);
        foreach($online_logs1 as $i => $log){
            $online_game = 0;
            // var_dump($log["peakData"]);die;
            $arr_data =  (array)  json_decode($log["peakData"]);
            if($gameId != -1){
                foreach ($arr_data as $key => $value) {
                    if($key == $gameId ){
                        $online_game = $value;
                        break;
                    }
                }
                $arr_log[date("H:i",strtotime($log["insertedTime"]))][0] = $online_game;
            } else {
                $sum  = array_sum($arr_data);
                $par = 0;
                $arrKey = array_keys($arr_data);
                if(in_array('0', $arrKey) == true){
                    $par = array_search('0', $arrKey);
                }
                $arr_log[date("H:i",strtotime($log["insertedTime"]))][0] = $sum - $arr_data["total"] - array_values($arr_data)[$par];
                // $arr_log[date("H:i",strtotime($log["insertedTime"]))][0] =  json_decode($log["peakData"])->total ? json_decode($log["peakData"])->total :0;

            }

        }
        $online_logs = OnlineLog::getOnlineLogHour(Date("Y-m-d"), $cp);
        foreach($online_logs as $i => $log){
            $online_game = 0;
            $arr_data =  (array)  json_decode($log["peakData"]);
                if($gameId != -1){
                    foreach ($arr_data as $key => $value) {
                        if($key == $gameId ){
                            $online_game = $value;
                            break;
                        }
                    }
                    $arr_log[date("H:i",strtotime($log["insertedTime"]))][1] = $online_game;
                } else {
                    $sum  = array_sum($arr_data);
                    $par = 0;
                    $arrKey = array_keys($arr_data);
                    if(in_array('0', $arrKey) == true){
                        $par = array_search('0', $arrKey);
                    }
                    $arr_log[date("H:i",strtotime($log["insertedTime"]))][1] = $sum - $arr_data["total"] - array_values($arr_data)[$par];
                    // $arr_log[$log["insertedTime"]] = array(json_decode($log["peakData"])->total, $sum - $arr_data["total"] - array_values($arr_data)[$par] );
                    // $arr_log[date("H:i",strtotime($log["insertedTime"]))][1] =  json_decode($log["peakData"])->total ? json_decode($log["peakData"])->total :0;

                }


            // $arr_log[date("H:i",strtotime($log["insertedTime"]))][1] = json_decode($log["peakData"])->total ? json_decode($log["peakData"])->total :0;

        }

        return $arr_log;
    }
}
