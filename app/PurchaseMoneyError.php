<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseMoneyError extends Model
{
    protected $table = 'purchase_money_error';

    public $timestamps = false;

    protected $primaryKey = 'purchaseErrorId';
}
