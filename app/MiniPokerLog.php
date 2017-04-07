<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MiniPokerLog extends Model
{
    protected $table = 'minipoker_log';

    public $timestamps = false;

    protected $primaryKey = 'logId';

    public static function getSumKenByRound($userId, $type, $card, $fromDate, $toDate)
    {
        $query = DB::table('minipoker_log as a');
        $query->select(DB::raw("count(a.logId) as count_router"), 'a.cardType as cardType');

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('insertTime',[$start,$end]);
        }

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($type != ''){
            $matchThese['betMoney'] = $type;
        }

        if($card != ''){
            $matchThese['cards'] = $card;
        }

        $query->where($matchThese);

        $query->groupBy("a.cardType");
        return $query->get()->toArray();
    }

    public static function getSumByFilter($userId, $type, $card, $fromDate, $toDate)
    {
        $query = DB::table('minipoker_log as a');
        $query->select(DB::raw("sum(a.betMoney) as sum_bet"), DB::raw("sum(a.winMoney) as sum_win") );

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('insertTime',[$start,$end]);
        }

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($type != ''){
            $matchThese['betMoney'] = $type;
        }

        if($card != ''){
            $matchThese['cardType'] = $card;
        }

        $query->groupBy("a.isCash");
        return $query->get()->toArray();
    }
}
