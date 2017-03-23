<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';

    public $timestamps = false;

    protected $primaryKey = 'notificationId';
}
