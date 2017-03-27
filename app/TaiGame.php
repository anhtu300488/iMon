<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaiGame extends Model
{
    protected $table = 'tai_game';

    protected $fillable = ['os', 'link_tai', 'file_down', 'is_direct', 'status', 'file_down', 'delay'];
}
