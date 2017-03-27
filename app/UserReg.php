<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReg extends Model
{
    protected $table = 'user';

    public $timestamps = false;

    public function purchaseMoneyLogs()
    {
        return $this->belongsToMany('App\PurchaseMoneyLog', 'purchase_money_log');
    }
}
