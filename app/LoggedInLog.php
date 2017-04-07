<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoggedInLog extends Model
{
    protected $table = 'logged_in_log';

    public static function getPlayUserInday($created_at)
    {
        return DB::table('logged_in_log as a')
            ->select (DB::raw('count(DISTINCT a.userId) count'), DB::raw('date(a.loggedInTime) date'))
            ->groupBy(DB::raw('date(a.loggedInTime)'))
            ->where("a.loggedInTime",">", $created_at)
            ->get()->toArray();
    }
}
