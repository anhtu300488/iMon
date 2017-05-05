<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatistic extends Model
{
    protected $table = 'user_statistic';

    public $timestamps = false;

    protected $primaryKey = 'logId';

    public static function getTotalMatchByUserId($id){
        $query = DB::table('user_statistic');
        $query->select("gameId", DB::raw('winningMatch+drawMatch+losingMatch as total'));
        $query->where('period', '=', 0);
        if($id != ''){
            $query->where('userId','=', $id);
        }
        $data = $query->groupBy("gameId")->get();
//        var_dump($data);die;
        return $data;
    }
}
