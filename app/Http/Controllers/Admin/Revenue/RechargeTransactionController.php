<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\ClientType;
use App\Partner;
use App\PurchaseMoneyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RechargeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : explode(" - ", getToday());
        $datePlayGame = \Request::get('date_play_game') ? explode(" - ", \Request::get('date_play_game')): null;
        $type = \Request::get('type');
        $cp = \Request::get('partner');
        $os = \Request::get('clientType');
        $displayName = \Request::get('displayName');
        $userId = \Request::get('userId');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $partner = Partner::pluck('partnerName', 'partnerId');

        $partner->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $typeArr = array('' => '---Tất cả---', 1 => 'Thẻ cào', 2 => 'SMS', 3 => 'IAP');

        $matchThese = [];
        if($type != ''){
            $matchThese['type'] = $type;
        }

        $query = PurchaseMoneyLog::select('*', DB::raw('user.displayName AS displayName'))
        ->join('user', function($join)
        {
            $join->on('user.userId', '=', 'purchase_money_log.userId');

        });
        if($userName != ''){
            $query->where('purchase_money_log.userName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
        }
        if($userId != ''){
            $query->where('user.userId','=',$userId);
        }
        $query->where($matchThese);

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('purchase_money_log.purchasedTime',[$start,$end]);
            }
        }

        if($datePlayGame != ''){
            $startPlayGame = $datePlayGame[0];

            $endPlayGame = $datePlayGame[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
            }
        }

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;

        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;

        $data = $query->orderBy('purchase_money_log.purchasedTime', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.revenue.rechargeTransaction.index',compact('data', 'partner', 'clientType', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function downloadExcel(Request $request){
        $userName = \Request::get('userName');
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : explode(" - ", getToday());
        $datePlayGame = \Request::get('date_play_game') ? explode(" - ", \Request::get('date_play_game')): null;
        $type = \Request::get('type');
        $cp = \Request::get('partner');
        $os = \Request::get('clientType');
        $displayName = \Request::get('displayName');
        $userId = \Request::get('userId');

        $partner = Partner::pluck('partnerName', 'partnerId');

        $partner->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $typeArr = array('' => '---Tất cả---', 1 => 'Thẻ cào', 2 => 'SMS', 3 => 'IAP');

        $matchThese = [];
        if($type != ''){
            $matchThese['type'] = $type;
        }

        $query = PurchaseMoneyLog::select(DB::raw('user.userId AS userId'), DB::raw('user.userName AS userName'), DB::raw('user.displayName AS displayName'), "parValue", "cashValue", "currentCash", "type", "description", "purchasedTime")
            ->join('user', function($join)
            {
                $join->on('user.userId', '=', 'purchase_money_log.userId');

            });
        if($userName != ''){
            $query->where('purchase_money_log.userName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
        }
        if($userId != ''){
            $query->where('user.userId','=',$userId);
        }
        $query->where($matchThese);

        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('purchase_money_log.purchasedTime',[$start,$end]);
            }
        }

        if($datePlayGame != ''){
            $startPlayGame = $datePlayGame[0];

            $endPlayGame = $datePlayGame[1];

            if($startPlayGame != '' && $endPlayGame != ''){
                $start1 = date("Y-m-d 00:00:00",strtotime($startPlayGame));
                $end1 = date("Y-m-d 23:59:59",strtotime($endPlayGame));
                $query->whereBetween('user.startPlayedTime',[$start1,$end1]);
            }
        }

        $results = $query->orderBy('purchase_money_log.purchasedTime', 'desc')->get();
//        var_dump($results);die;
        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = $result->toArray();
            $data[$k]["type"] = $typeArr[$result->type];

        }
        // Generate and return the spreadsheet
        ini_set('max_execution_time', 360);
        ini_set('memory_limit', '-1');
        return \Maatwebsite\Excel\Facades\Excel::create('recharge_transaction', function($excel) use ($data) {
            $excel->sheet('recharge_transaction', function($sheet) use ($data)
            {
                $headings = array('User ID', 'Tên hiển thị','Tên đăng nhập','Mệnh giá','Cash value','Mon hiện tại', 'Loại', 'Mô tả', 'Purchased time');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }
}
