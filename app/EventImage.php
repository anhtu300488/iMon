<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    protected $table = 'event_image';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['status', 'link', 'content', 'enable_content'];
}