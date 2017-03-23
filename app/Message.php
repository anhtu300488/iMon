<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    public $timestamps = false;

    protected $primaryKey = 'messageId';
}
