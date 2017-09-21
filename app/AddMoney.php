<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddMoney extends Model
{
    protected $table = 'add_money';

    protected $fillable = ['userId', 'addCash', 'addGold', 'description', 'admin_id'];


    public static function getListDataBySearch(){

    }
}
