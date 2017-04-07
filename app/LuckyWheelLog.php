<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LuckyWheelLog extends Model
{
    protected $table = 'lucky_wheel_log';

    public $timestamps = false;

    protected $primaryKey = 'logId';

    public static function getSumKenByRound($userId, $roundItem, $description, $fromDate, $toDate)
    {
        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        $query = DB::table('lucky_wheel_log as a');
        $query->select(DB::raw("count(i.value) as sum_ken"), 'a.round2_item', 'i.description as description');
        $query->join('lucky_wheel_item as i', function($join)
        {
            $join->on('i.itemId', '=', 'a.round2_item');

        });
        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('a.time',[$start,$end]);
        }
        $query->where($matchThese);

        $query->groupBy("a.round2_item");
        return $query->get()->toArray();
    }
}
