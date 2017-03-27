<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchLog extends Model
{
    protected $table = 'match_log';

    public $timestamps = false;

    protected $primaryKey = 'matchLogId';
}
