<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuickTip extends Model
{
	public $timestamps = false;
    protected $table = 'quick_tip';
    protected $primaryKey = 'tipId';
    protected $fillable = ['content', 'active', 'cp'];
}