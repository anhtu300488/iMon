<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OnlineLog extends Model
{
    protected $table = 'online_log';


    public static function getOnlineLog($insertedtime = null, $option = null)
    {
        $sql = OnlineLog::select(DB::raw('logId, peakData, insertedTime'));

        if ($insertedtime != ''){
            $sql->where(DB::raw('DATE(insertedTime)'), '=' , date("Y-m-d",strtotime($insertedtime)));
            $sql->where(DB::raw('logId % 4'), '=', 1);

//            $sql = "select logId, peakData, insertedTime from online_log where insertedTime = ? and logId %4 = 1";
        } else {
            if($option == 1 || $option == 2 || $option == 6){
                $sql->where('insertedTime' , '>=', date("Y-m-d H:i:s", time() - 3600 * $option));
            } else if($option == 24){
                $sql->where(DB::raw('DATE(insertedTime)'), '=' ,date("Y-m-d",strtotime(Carbon::now())));
                $sql->where(DB::raw('logId % 4'), '=', 1);
            }
        }

        return  $sql->orderBy('insertedTime', 'desc')->take(1)->get();
    }
}
