<?php

namespace App\Http\Controllers\Admin\Users;

use App\BlackListUser;
use App\ClientType;
use App\LoggedInLog;
use App\Partner;
use App\UserReg;
use App\UserResetPw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class UserRegisterController extends Controller
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
        $dateRegister = \Request::get('date_register') ? explode(" - ", \Request::get('date_register')) : null;
        $device = \Request::get('device');
        $deviceIdentify = \Request::get('deviceIdentify');
        $os = \Request::get('clientType');
        $ip = \Request::get('ip');
        $status = \Request::get('status');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $statusArr = array('' => '---Tất cả---', 0 => 'Không hoạt động', 1 => 'Hoạt động', 3 => 'Tạm khóa');

        $partner = Partner::pluck('partnerName', 'partnerId');

        $partner->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $matchThese = [];
        if($os != ''){
            $matchThese['clientId'] = $os;
        }

        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($status != ''){
            $matchThese['status'] = $status;
        }
        $query = UserReg::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($displayName != ''){
            $query->where('displayName','LIKE','%'.$displayName.'%');
        }

        if($device != ''){
            $query->where('device','LIKE','%'.$device.'%');
        }

        if($ip != ''){
            $query->where('ip','LIKE','%'.$ip.'%');
        }

        if($deviceIdentify != ''){
            $query->where('deviceIdentify','=', $deviceIdentify);
        }

        $query->where($matchThese);
        if($dateRegister != ''){
            $startDateCharge = $dateRegister[0];

            $endDateCharge = $dateRegister[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('registedTime',[$start,$end]);
            }
        }

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('registedTime', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        $total_by_os = UserReg::getTotalUserByOs();

        $day = 60*60*24; $day_7 = time() - 6*$day;
        $register_info = UserReg::getRegisterInfo(Date("Y-m-d", strtotime(Carbon::now().' -6 days')));
        $register_info_new = UserReg::getRegisterInfoNew(Date("Y-m-d", strtotime(Carbon::now().' -6 days')));
        $user_play_inday  =  UserReg::getPlayUserInday(Date("Y-m-d", strtotime(Carbon::now().' -6 days')));
        $user_login_inday = LoggedInLog::getPlayUserInday(Date("Y-m-d", strtotime(Carbon::now().' -6 days')));
//        $register_info_new = UserTable::getRegisterInfoNew(date("Y-m-d", $day_7) . "00:00:00");
        $created_at = array();
        //tai khoan moi
        foreach($register_info as $date){
//            var_dump($date->date);die;
            $created_at[$date->date] = $date->count;
        }
        // thiet bị moi
        $created_at_new = array();

        foreach($register_info_new as $date){
            $created_at_new[$date->date] = $date->count;
        }
        // nguoi choi hang ngay
        $play_in_day= array();

        foreach($user_play_inday as $date){
            $play_in_day[$date->date] = $date->count;
        }
        // nguoi choi trong ngay
        $login_in_day= array();
        foreach($user_login_inday as $date){
            $login_in_day[$date->date] = $date->count;
        }
        $sevent_day = array();

        for($i=0; $i<7; $i++) {
            $sevent_day[date("d/m/Y", $day_7 + $i* $day)] = array(
                isset($created_at[date("Y-m-d", $day_7 + $i* $day)]) ? $created_at[date("Y-m-d", $day_7 + $i* $day)]: 0,
                isset($created_at_new[date("Y-m-d", $day_7 + $i* $day)]) ? $created_at_new[date("Y-m-d", $day_7 + $i* $day)]: 0,
                isset($play_in_day[date("Y-m-d", $day_7 + $i* $day)]) ? $play_in_day[date("Y-m-d", $day_7 + $i* $day)]: 0,
                isset($login_in_day[date("Y-m-d", $day_7 + $i* $day)]) ? $login_in_day[date("Y-m-d", $day_7 + $i* $day)]: 0,
            );

        }

        return view('admin.users.userReg.index',compact('data', 'partner', 'clientType', 'total_by_os', 'sevent_day', 'statusArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }


    public function downloadExcel(Request $request){

        $userId = \Request::get('userId');
        $userName = \Request::get('userName');
        $displayName = \Request::get('displayName');
        $dateRegister = \Request::get('date_register') ? explode(" - ", \Request::get('date_register')) : null;
        $device = \Request::get('device');
        $deviceIdentify = \Request::get('deviceIdentify');
        $os = \Request::get('clientType');
        $ip = \Request::get('ip');
        $status = \Request::get('status');

        $partner = Partner::pluck('partnerName', 'partnerId');

        $partner->prepend('---Tất cả---', '');

        $clientType = ClientType::pluck('name', 'clientId');

        $clientType->prepend('---Tất cả---', '');

        $matchThese = [];
        if($os != ''){
            $matchThese['clientId'] = $os;
        }

        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        if($status != ''){
            $matchThese['status'] = $status;
        }

        $query = UserReg::query()->select("userId", "userName","displayName", "ip", "device", "deviceIdentify", "cp", "clientId", "registedTime");
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($displayName != ''){
            $query->where('displayName','LIKE','%'.$displayName.'%');
        }

        if($device != ''){
            $query->where('device','LIKE','%'.$device.'%');
        }

        if($ip != ''){
            $query->where('ip','LIKE','%'.$ip.'%');
        }

        if($deviceIdentify != ''){
            $query->where('deviceIdentify','=',$deviceIdentify);
        }


        $query->where($matchThese);

        if($dateRegister != ''){
            $startDateCharge = $dateRegister[0];

            $endDateCharge = $dateRegister[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('registedTime',[$start,$end]);
            }
        }

        $results = $query->orderBy('registedTime', 'desc')->get();

        // generator.
        $data = [];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($results as $k => $result) {
            $data[] = $result->toArray();
            $data[$k]["userName"] = str_replace('=','\=',$result->userName);
            $data[$k]["displayName"] = str_replace('=','\=',$result->displayName);
            $data[$k]["clientId"] = $clientType[$result->clientId];

        }
        // Generate and return the spreadsheet
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '-1');
        return \Maatwebsite\Excel\Facades\Excel::create('user_reg', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $headings = array('User ID','Tên đăng nhập', 'Tên hiển thị','IP','Thiết bị','Device ID','Đối tác', 'Nền tảng', 'Ngày đăng ký');
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->prependRow(1, $headings);
            });
        })->download('xlsx');

    }

    public function lockUser(Request $request){
        $this->validate($request, [
            'userId' => 'required',
            'type' => 'required',
            'reason' => 'required',
        ]);
        $idStr = Input::get('userId');
        $type = Input::get('type');
        $reason = Input::get('reason');
        $ids = explode(",", $idStr);
        $lockType = 2;
        if($type == 1){
            $lockType = 1;
        } elseif ($type == 2 ){
            $lockType = 2;
        }

        $data = array();
        foreach ($ids as $id){
            $arr = array('userId'=> $id, 'userLockId'=> Auth::user()->id, 'reason'=> $reason, 'lockType' => $lockType);
            array_push($data, $arr);
        }

        BlackListUser::insert($data);
        return redirect()->route('users.userReg')
            ->with('message','Lock User Successfully');

    }

    public function unlockUser(Request $request){
        $this->validate($request, [
            'userIds' => 'required'
        ]);
        $ids = $request->get('userIds');

        UserReg::whereIn('userId', $ids)->update(['status' => 1]);
        return redirect()->route('users.userReg')
            ->with('message','UnLock User Successfully');

    }

    public function resetUser(Request $request){
        $this->validate($request, [
            'resetUserId' => 'required',
            'description' => 'required',
            'password' => 'required|same:password',
            'confirm_password' => 'required|same:password',
        ]);
        $idStr = Input::get('resetUserId');
        $description = Input::get('description');
        $password = Input::get('password');
        $ids = explode(",", $idStr);

        $data = array();
        foreach ($ids as $id){
            $arr = array('userId'=> $id, 'password'=> $password, 'description'=> $description);
            array_push($data, $arr);
        }

        UserResetPw::insert($data);
        return redirect()->route('users.userReg')
            ->with('message','Reset Password Successfully');

    }
}


