<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftOrder extends Model
{
    protected $table = 'gift_order';

    public $primaryKey = 'orderId';

    public $timestamps = false;

    protected $fillable = ['eventId', 'quantity', 'includeAlphabet', 'cashValue', 'vqmmTurn', 'cardPromotion', 'cardPromotionTurn', 'expiredTime'];
}
