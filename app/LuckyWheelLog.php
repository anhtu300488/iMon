<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuckyWheelLog extends Model
{
    protected $table = 'lucky_wheel_log';

    public $timestamps = false;

    protected $primaryKey = 'logId';
}
