<?php

namespace App\Http\Controllers\Admin\Users;

use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
        $device = \Request::get('device');
        $phone = \Request::get('phone');
        $top = \Request::get('top');

        $list_top = array(null => "startPlayedTime", 1 => "level", 2 => "cash", 3 => "gold", 4 => "totalMatch", 5 => "totalWin", 6 => "");
//        var_dump($list_top[$top]);die;
        $query = UserReg::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($device != ''){
            $query->where('device','LIKE','%'.$device.'%');
        }

        if($phone != ''){
            $query->where('verifiedPhone','LIKE','%'.$phone.'%');
        }

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d",strtotime($fromDate));
            $end = date("Y-m-d",strtotime($toDate));
            $query->whereBetween('lastLoginTime',[$start,$end]);
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 50;
        $data = $query->orderBy($list_top[$top], 'desc')->paginate($perPage);

        return view('admin.users.userInfo.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
