<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    protected $table = 'game';

    public static function getListGame($gameId = null)
    {
        $sql = Game::query()
            ->where('status', '=', 1);
        if($gameId){
            $sql->where('gameid', '=', $gameId);
        }
        return $sql->get();
    }
}
