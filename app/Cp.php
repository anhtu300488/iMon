<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cp extends Model
{
    protected $table = 'cp';

    protected $primaryKey = 'cpId';

    public $timestamps = false;

    protected $fillable = ['cpName', 'chargingUri', 'topupUri'];
}
