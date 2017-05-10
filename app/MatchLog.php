<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MatchLog extends Model
{
    protected $table = 'match_log';

    public $timestamps = false;

    protected $primaryKey = 'matchLogId';

    public static function getTotalGame($gameId = null, $createdTime)
    {
        $query = DB::table('match_log as a');
        $query->select(DB::raw('DATE(a.createdTime) as day'), "a.gameId as gameId", DB::raw('COUNT(a.gameId) as total') );

        if($createdTime != ''){
            $query->where(DB::raw('DATE(a.createdTime)'), '=' ,date("Y-m-d",strtotime($createdTime)));
        }

        if($gameId){
            $query->where('a.gameId','=', $gameId);
        }
        $data = $query->groupBy(DB::raw('DATE(a.createdTime)'),'a.gameId')->orderBy(DB::raw('DATE(a.createdTime)'),'desc')->get()->toArray();


        return $data;
    }
}
