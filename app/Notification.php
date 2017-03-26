<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';

    public $timestamps = false;

    protected $primaryKey = 'notificationId';

    protected $fillable = ['title', 'message', 'pushHour', 'pushMinutes', 'repeat_daily', 'status', 'pushTime', 'admin_id'];
}
