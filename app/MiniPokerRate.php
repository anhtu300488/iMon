<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiniPokerRate extends Model
{
    protected $table = 'minipoker_rate';

    public $timestamps = false;

    protected $primaryKey = 'rateId';
}
