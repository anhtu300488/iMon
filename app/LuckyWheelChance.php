<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuckyWheelChance extends Model
{
    protected $table = 'lucky_wheel_chance';

    public $timestamps = false;

    protected $primaryKey = 'chanceId';
}
