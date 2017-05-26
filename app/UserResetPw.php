<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserResetPw extends Model
{
    protected $table = 'user_reset_pw';

    public $timestamps = false;

    protected $primaryKey = 'pwId';
}
