<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuckyWheelItem extends Model
{
    protected $table = 'lucky_wheel_item';

    public $timestamps = false;

    protected $primaryKey = 'itemId';
}
