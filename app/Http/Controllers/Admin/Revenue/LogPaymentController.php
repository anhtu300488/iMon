<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Cp;
use App\LogPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LogPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = \Request::get('userId');
        $userName = \Request::get('userName');
        $displayName = \Request::get('displayName');
        $seria = \Request::get('seria');
        $pinCard = \Request::get('pinCard');
        $money = \Request::get('money');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;

        $partner_qr =  Cp::where('cpId','!=', 1);
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');
        $partner->prepend('---Tất cả---', '');
        $query = LogPayment::query();
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'log_payment.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
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
                $query->whereBetween('created_at', array($date1Str, $date2Str));
            }
        } else {
            $query->where("created_at",  ">",  Date("Y-m-d"));
        }
        $matchThese = [];
        if($money != ''){
            $matchThese['money'] = $money;
        }

        if($seria != ''){
            $query->where('seria','LIKE','%'.$seria.'%');
        }

        if($pinCard != ''){
            $query->where('pin_card','LIKE','%'.$pinCard.'%');
        }
        if($userId != ''){
            $query->where('log_payment.userId','=',$userId);
        }
        if($cp != ''){
            $query->where('user.cp','=',$cp);
        }
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($userName != ''){
            $query->where('user.userName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
        }
        $chanel = array("" => "---Tất cả---", "1" => "PAYGATE-Trúc", "2" => "SANTHE" , "3" => "PAYDIRECT-ĐÔ");

        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at','desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.revenue.logPayment.index',compact('data','partner', 'chanel'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
        public function downloadExcel(Request $request){
        $userId = \Request::get('userId');
        $userName = \Request::get('userName');
        $displayName = \Request::get('displayName');
        $seria = \Request::get('seria');
        $pinCard = \Request::get('pinCard');
        $money = \Request::get('money');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $cp = \Request::get('partner') ? \Request::get('partner') : Auth::user()->cp_id;
        $partner_qr =  Cp::where('cpId','!=', 1);
 
        if(Auth::user()->id == "100033"){
            $partner_qr->whereIn("cpId",  [1,17,18,19,21]);
        }
        $partner = $partner_qr->pluck('cpName', 'cpId');
        $partner->prepend('---Tất cả---', '');
        $query = LogPayment::query()->select("user.userId","userName", DB::raw('user.displayName as displayName'), "seria", "pin_card", "money", "message", "providerId" , "created_at", "type", "created_at");
        $query->join('user', function($join)
        {
            $join->on('user.userId', '=', 'log_payment.userId');

        });
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
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
                $query->whereBetween('created_at', array($date1Str, $date2Str));
            }
        } else {
            $query->where("created_at",  ">",  Date("Y-m-d"));
        }
        $matchThese = [];
        if($money != ''){
            $matchThese['money'] = $money;
        }

        if($seria != ''){
            $query->where('seria','LIKE','%'.$seria.'%');
        }

        if($pinCard != ''){
            $query->where('pin_card','LIKE','%'.$pinCard.'%');
        }
        if($userId != ''){
            $query->where('log_payment.userId','=',$userId);
        }
        if($cp != ''){
            $query->where('user.cp','=',$cp);
        }
        if(Auth::user()->id == "100033"){
            $query->whereIn("user.cp",  [1,17,18,19,21]);
        }
        if($userName != ''){
            $query->where('user.userName','LIKE','%'.$userName.'%');
        }
        if($displayName != ''){
            $query->where('user.displayName','LIKE','%'.$displayName.'%');
        }

        $results = $query->orderBy('created_at','desc')->get();
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
