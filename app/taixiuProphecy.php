<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class taixiuProphecy extends Model
{
    protected $table = 'taixiu_prophecy';

    public $timestamps = false;

    protected $fillable = ['isGreat'];
}
