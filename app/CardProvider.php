<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardProvider extends Model
{
    protected $table = 'card_provider';

    public $timestamps = false;

    protected $primaryKey = 'providerId';
}
