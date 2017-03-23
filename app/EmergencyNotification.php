<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencyNotification extends Model
{
    protected $table = 'emergency_notification';

    public $timestamps = false;

    protected $primaryKey = 'notificationId';
}
