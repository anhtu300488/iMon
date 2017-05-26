<?php

namespace App\Http\Controllers\Admin\Users;

use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class UserLockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userName = \Request::get('userName');
        $userID = \Request::get('userID');
        $displayName = \Request::get('displayName');
        $dateCharge = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : getToday();
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = UserReg::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        if($displayName != ''){
            $query->where('displayName','LIKE','%'.$displayName.'%');
        }

        if($userID != ''){
            $query->where('userId','=',$userID);
        }

        $query->where('status','!=', 1);
        if($dateCharge != ''){
            $startDateCharge = $dateCharge[0];

            $endDateCharge = $dateCharge[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('lockToTime',[$start,$end]);
            }
        }

        $query->with(['blackListUser']);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('userName', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.users.userLock.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
