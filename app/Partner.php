<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partner';

    protected $primaryKey = 'partnerId';

    public $timestamps = false;

    protected $fillable = ['partnerName', 'smsNumber', 'userName', 'password', 'accessKey1', 'accessKey2','admin_id'];
}
