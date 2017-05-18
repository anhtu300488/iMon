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
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');
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

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d 00:00:00",strtotime($fromDate));
            $end = date("Y-m-d 23:59:59",strtotime($toDate));
            $query->whereBetween('lockToTime',[$start,$end]);
        }
        $query->with(['blackListUser']);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('userName', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.users.userLock.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
