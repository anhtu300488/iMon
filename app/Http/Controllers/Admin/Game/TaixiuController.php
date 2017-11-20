<?php

namespace App\Http\Controllers\Admin\Game;

use App\MatchLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class TaixiuController extends Controller
{
    public function index(Request $request){
        $typeArr = array('' => '---Tất cả---', 1 => 'Ken', 2 => 'Xu');

        $roomId = \Request::get('roomId');
        $matchIndex = \Request::get('matchIndex');
        $type = \Request::get('type');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $userId = \Request::get('userId');

        $query = MatchLog::query()->where("gameId", "=", 17);
        if($roomId != ''){
            $query->where('roomId','LIKE','%'.$roomId.'%');
        }

        $sessionId = \Request::get('sessionId');
        if($sessionId != ''){
            $query->where('sessionId','=', $sessionId );
        }

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
                $query->whereBetween('createdTime', array($date1Str, $date2Str));
            }
        } else {
            $query->where("createdTime",  ">",  Date("Y-m-d"));
        }
        if($userId != ''){
            $query->where('description','LIKE','%'.$userId.'%');
        } else {
            if($sessionId == ''){
                $query->where('matchLogId','=',1);
            }
        }
        // if($type ==  1){
        //     $query->where("description", 'like', "%true%");
        // } else if($type ==  2){
        //     $query->where("description", 'not like',  "%true%");
        // }
//        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
//        $startLimit = $perPage * ($page - 1);
//        $endLimit = $perPage * $page;
//        $data = $query->orderBy('createdtime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('matchLogId', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);
        return view('admin.game.taixiu.index',compact('data', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
    public function downloadExcel(Request $request){
        $roomId = \Request::get('roomId');
        $matchIndex = \Request::get('matchIndex');
        $type = \Request::get('type');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $userId = \Request::get('userId');

        $query = MatchLog::query()->where("gameId", "=", 17);
        if($roomId != ''){
            $query->where('roomId','LIKE','%'.$roomId.'%');
        }

        $sessionId = \Request::get('sessionId');
        if($sessionId != ''){
            $query->where('sessionId','=', $sessionId );
        }
 

        $results = $query->orderBy('matchLogId','desc')->get();
//        var_dump($results);die;
        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = array($result->userId, $result->userName, $result->displayName, $result->seria, $result->pin_card, number_format($result->money), $result->message, $result->providerId, $result->type, $result->created_at);
        }
        // Generate and return the spreadsheet
        ini_set('max_execution_time', 360);
        ini_set('memory_limit', '-1');
        return \Maatwebsite\Excel\Facades\Excel::create('logPayment', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $headings = array('User ID', 'Tên đăng nhập','Tên hiển thị','Seria','Mã thẻ','Mệnh giá', 'Message', 'Nhà cung cấp', 'Kênh gạch', 'Thời gian');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');
    }
}
