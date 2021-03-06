<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OnlineLog extends Model
{
    protected $table = 'online_log';


    public static function getOnlineLog($insertedtime = null, $option = null,$cp = null)
    {
        $sql = OnlineLog::select(DB::raw('logId, peakData, insertedTime'));
        if ($insertedtime != '' && $insertedtime != date("d-m-Y",strtotime(Carbon::now())) ){
            $sql->where(DB::raw('DATE(insertedTime)'), '=' , date("Y-m-d",strtotime($insertedtime)));
            $sql->where(DB::raw('logId % 10'), '=', 1);
        } else {
            if($option == 1 || $option == 2 || $option == 6){
                $start = date("Y-m-d H:i:s", time() - 3600* $option);
                $end = date("Y-m-d H:i:s",strtotime(Carbon::now()));
                $sql->whereBetween('insertedTime',[$start,$end]);
            } else if($option == 24){
                $sql->where(DB::raw('DATE(insertedTime)'), '=' ,date("Y-m-d",strtotime(Carbon::now())));
                $sql->where(DB::raw('logId % 4'), '=', 1);
            }
        }

        if($cp != null){
            $sql->where('cp', '=', $cp);
        }
      //  if(Auth::user()->id == "100033"){
         //   $sql->whereIn("cp",  [1,17,18,19,21]);
      //  }
        if($cp == null){
            $sql->where('cp', '=', -1);
        }

        return  $sql->orderBy('insertedTime', 'desc')->limit(500)->get();
    }

    public static function getCurrentOnlineLog($insertedtime = null, $option = null)
    {
        $sql = OnlineLog::select(DB::raw('logId, peakData, insertedTime'));
        if ($insertedtime != '' && $insertedtime != date("d-m-Y",strtotime(Carbon::now())) ){
            $sql->where(DB::raw('DATE(insertedTime)'), '=' , date("Y-m-d",strtotime($insertedtime)));
            $sql->where(DB::raw('logId % 4'), '=', 1);
        } else {
            if($option == 1 || $option == 2 || $option == 6){
                $sql->where('insertedTime' , '>=', Date("Y-m-d H:i:s", time() - 3600* $option));
            } else if($option == 24){
                $sql->where(DB::raw('DATE(insertedTime)'), '=' ,date("Y-m-d",strtotime(Carbon::now())));
                $sql->where(DB::raw('logId % 4'), '=', 1);
            }
        }

        return  $sql->orderBy('insertedTime', 'desc')->limit(1)->get();
    }

    public static function getOnlineLogHour($insertedtime = null, $cp = null)
    {
        $sql = OnlineLog::select(DB::raw('logId, peakData, insertedTime'));

        if ($insertedtime != '' ){
            // $start = $insertedtime  . ;
            // $end = date("Y-m-d H:i:s",strtotime($insertedtime));
            $sql->whereBetween('insertedTime',[$insertedtime . " 00:00:00",$insertedtime . " 23:59:59"]);
//            $sql->where(DB::raw('DATE(insertedTime)'), '=' , date("Y-m-d",strtotime($insertedtime)));
        }
        if($cp != 1 && $cp != null){
            $sql->where('cp', '=', $cp);
        } else {
            $sql->where('cp', '=', -1);
        }
        if(Auth::user()->id == "100033"){
            // $sql->whereIn("cp",  [1,17,18,19,21]);
        }

        return  $sql->orderBy('logId', 'desc')->get();
    }
}
