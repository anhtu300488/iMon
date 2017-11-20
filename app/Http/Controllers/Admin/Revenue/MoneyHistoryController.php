<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Game;
use App\MoneyLog;
use App\MoneyTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MoneyHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $userName = \Request::get('userName');
//        $userId = \Request::get('userId') ? \Request::get('userId') : -1;
        $userId = \Request::get('userId');
        $type = \Request::get('type');
        $game = \Request::get('game');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $gameArr = Game::where('status',1)->pluck('name', 'gameId');

        $gameArr->prepend('Hệ thống', -1);
        $gameArr->prepend('---Tất cả---', '');

        $transactionArr = MoneyTransaction::pluck('type', 'transactionId');

        $typeArr = array('' => '---Tất cả---', 1 => "Mon");

        $query = MoneyLog::query();

        if($game != ''){
            $query->where('gameId','=',$game);
        }
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        if($userId != ''){
            $query->where('userId','=',$userId);
        }
        if($type != ''){
            if($type == 1){
                $query->where('changeCash','!=', 0);
            }
            elseif($type == 2){
                $query->where('changeCash','=', 0);
            }
        }

//        $query->where('gameId','!=', -1);

        $fromDate = \Request::get('fromDate');
        if($fromDate != ''){
            $text = trim($fromDate);
            $dateArr = explode('-', $text);
            if (count($dateArr) == 2) {
                $date1 = trim($dateArr[0]);
                $day_time1 = explode(' ', $date1);
                $date1Arr = explode('/', $day_time1[0]);
                $date1Str = '';
                if (count($date1Arr) == 3) {
                    $date1Str = $date1Arr[2] . '-' . $date1Arr[1] . '-' . $date1Arr[0] . ' ' .  $day_time1[1];
                }
                $date2 = trim($dateArr[1]);
                $day_time2 = explode(' ', $date2);
                $date2Arr = explode('/', $day_time2[0]);
                $date2Str = '';
                if (count($date2Arr) == 3) {
                    $date2Str = $date2Arr[2] . '-' . $date2Arr[1] . '-' . $date2Arr[0] . ' ' .  $day_time2[1];
                }
                $query->whereBetween('insertedTime', array($date1Str, $date2Str));
            }
        } else {
            $query->where("insertedTime",  ">",  Date("Y-m-d"));
        }

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('insertedTime', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

//        var_dump($data);die;

        return view('admin.revenue.historyMoney.index',compact('data', 'typeArr', 'gameArr', 'transactionArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
            public function downloadExcel(Request $request){
        $userName = \Request::get('userName');
//        $userId = \Request::get('userId') ? \Request::get('userId') : -1;
        $userId = \Request::get('userId');
        $type = \Request::get('type');
        $game = \Request::get('game');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $gameArr = Game::where('status',1)->pluck('name', 'gameId');

        $gameArr->prepend('Hệ thống', -1);
        $gameArr->prepend('---Tất cả---', '');

        $transactionArr = MoneyTransaction::pluck('type', 'transactionId');

        $typeArr = array('' => '---Tất cả---', 1 => "Mon");


        $query = MoneyLog::query()->select("userId","userName", "lastCash", "changeCash", "currentCash", "transactionId", "taxPercent" , "taxValue", "gameId", "insertedTime", "description");


        $matchThese = [];
        if($game != ''){
            $query->where('gameId','=',$game);
        }
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        if($userId != ''){
            $query->where('userId','=',$userId);
        }
        $fromDate = \Request::get('fromDate');
        if($fromDate != ''){
            $text = trim($fromDate);
            $dateArr = explode('-', $text);
            if (count($dateArr) == 2) {
                $date1 = trim($dateArr[0]);
                $day_time1 = explode(' ', $date1);
                $date1Arr = explode('/', $day_time1[0]);
                $date1Str = '';
                if (count($date1Arr) == 3) {
                    $date1Str = $date1Arr[2] . '-' . $date1Arr[1] . '-' . $date1Arr[0] . ' ' .  $day_time1[1];
                }
                $date2 = trim($dateArr[1]);
                $day_time2 = explode(' ', $date2);
                $date2Arr = explode('/', $day_time2[0]);
                $date2Str = '';
                if (count($date2Arr) == 3) {
                    $date2Str = $date2Arr[2] . '-' . $date2Arr[1] . '-' . $date2Arr[0] . ' ' .  $day_time2[1];
                }
                $query->whereBetween('insertedTime', array($date1Str, $date2Str));
            }
        } else {
            $query->where("insertedTime",  ">",  Date("Y-m-d"));
        }
                if($game != ''){
            $query->where('gameId','=',$game);
        }
        $results = $query->orderBy('insertedTime','desc')->limit(100000)->get();
        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $game_name = isset($gameArr[$result->gameId]) ? $gameArr[$result->gameId] : $result->gameId;
            $data[] = array($result->userId, $result->userName, $result->lastCash, $result->changeCash, number_format($result->currentCash), $result->transactionId, $result->taxPercent, $result->taxValue, $game_name , $result->insertedTime, $result->description);
        }
        // Generate and return the spreadsheet
        ini_set('max_execution_time', 360);
        ini_set('memory_limit', '-1');
        return \Maatwebsite\Excel\Facades\Excel::create('MoneyHistory', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $headings = array('User ID', 'Tên đăng nhập','Mon ban đầu','Thay đổi Mon','Mon hiện tại', 'Loại giao dịch', 'Tax percent', 'Tax value', 'Game', 'Thời gian', 'Mô tả');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }
}
