<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agent';

    public $timestamps = false;

    protected $primaryKey = 'agentId';

    public static function getListAgency(){
        $query = Agent::query();
        $query->select("userId");
        $query->where('active','=', 1);

        $results = $query->get()->toArray();
        $data = [];
        foreach ($results as $k => $rs){
            $data[$k] = $rs['userId'];
        }

        return $data;
    }
}
