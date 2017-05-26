<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseMoneyMissing extends Model
{
    protected $table = 'purchase_money_missing';

    public $timestamps = false;

    protected $primaryKey = 'missId';

    public $fillable = ['provider','cardValue','userId','cardPin','cardSerial','arrCash','admin_id'];
}
