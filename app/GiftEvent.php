<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftEvent extends Model
{
    protected $table = 'gift_event';

//    public $timestamps = false;

    protected $primaryKey = 'giftEventId';

    protected $fillable = ['eventName','cashValue', 'goldValue', 'expiredTime', 'description'];
}
