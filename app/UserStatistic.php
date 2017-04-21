<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatistic extends Model
{
    protected $table = 'user_statistic';

    public $timestamps = false;

    protected $primaryKey = 'logId';
}
