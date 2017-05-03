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
        $fromDate = \Request::get('fromDate');
        $toDate = \Request::get('toDate');

        $query = UserReg::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }

        $query->where('status','=', 3);

        if($fromDate != '' && $toDate != ''){
            $start = date("Y-m-d 00:00:00",strtotime($fromDate));
            $end = date("Y-m-d 23:59:59",strtotime($toDate));
            $query->whereBetween('lockToTime',[$start,$end]);
        }
        $query->with(['blackListUser']);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('userName', 'desc')->paginate($perPage);

        return view('admin.users.userLock.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
