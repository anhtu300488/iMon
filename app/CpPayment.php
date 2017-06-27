<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CpPayment extends Model
{
    protected $table = 'cp_payment';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['name', 'url', 'type', 'status', 'description', 'cp_id'];
    public static function findByCpId($cpId)
    {
        return DB::table('cp_payment as a')
            ->select (DB::raw('type'),DB::raw('name'), DB::raw('url'))
            ->where("a.status","=","1")
            ->where("a.cp_id","=",$cpId)
            ->get()->toArray();
    }
}
