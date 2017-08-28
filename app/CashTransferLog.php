<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashTransferLog extends Model
{
    protected $table = 'cash_transfer_log';

    public $timestamps = false;

    protected $primaryKey = 'logId';

    public static function getMoneyTransfer($id){
        $query = DB::table('cash_transfer_log as a');
        $query->select(DB::raw("SUM(a.cashTransfer) sumMoney"));

        if($id != ''){
            $query->where('a.userId','=', $id);
        }

        $listAgency = Agent::getListAgency();
        $query->whereIn('a.targetUserId', [implode(",", $listAgency)]);
        $results = $query->get()->toArray();
        foreach ($results as $rs){
            $data = $rs->sumMoney;
        }


        return number_format($data);
    }

    public static function getMoneyReceived($id){
        $query = DB::table('cash_transfer_log as a');
        $query->select(DB::raw("SUM(a.cashTransfer) sumMoney"));

        if($id != ''){
            $query->where('a.targetUserId','=', $id);
        }

        $listAgency = Agent::getListAgency();
        $query->whereIn('a.userId', [implode(",", $listAgency)]);
        $results = $query->get()->toArray();
        foreach ($results as $rs){
            $data = $rs->sumMoney;
        }


        return number_format($data);
    }
}
