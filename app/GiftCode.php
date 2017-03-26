<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCode extends Model
{
    protected $table = 'gift_code';

    public $primaryKey = 'giftId';

    protected $fillable = ['giftEventId', 'userName', 'userId', 'expiredTime', 'description'];
}
