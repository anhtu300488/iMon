<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrashTableAlarm extends Model
{
    protected $table = 'crash_table_alarm';

    public $timestamps = false;

    protected $primaryKey = 'crashId';
}
