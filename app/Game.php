<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    protected $table = 'game';

    protected $primaryKey = 'gameId';

    public $timestamps = false;

    public static function getListGame($gameId = null)
    {
        $sql = Game::query()->select(DB::raw('gameId, name'))
            ->where('status', '=', 1);
        if($gameId){
            $sql->where('gameId', '=', $gameId);
        }
        return $sql->get();
    }
}
