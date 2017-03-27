<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebContent extends Model
{
    protected $table = 'web_content';

    protected $fillable = ['title','keywords','description','content','image','type', 'status', 'is_hot'];
}
