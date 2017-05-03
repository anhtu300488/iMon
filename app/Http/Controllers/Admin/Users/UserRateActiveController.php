<?php

namespace App\Http\Controllers\Admin\Users;

use App\ClientType;
use App\LoggedInLog;
use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UserRateActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loginTime = \Request::get('date_charge') ? explode(" - ", \Request::get('date_charge')) : null;

        $total1Rs = LoggedInLog::getTotalActive1R($loginTime);
        $total3Rs = LoggedInLog::getTotalActive3R($loginTime);
        $total5Rs = LoggedInLog::getTotalActive5R($loginTime);
        $total7Rs = LoggedInLog::getTotalActive7R($loginTime);
        $total30Rs = LoggedInLog::getTotalActive30R($loginTime);

        $login_arr = array();
        foreach ($total1Rs as $index => $total){
            $login_arr[$total->purchase_date][5] = isset($total->total) ? $total->total : 0;
        }

        foreach ($total3Rs as $index => $total){
            $login_arr[$total->purchase_date][0] = isset($total->total) ? $total->total : 0;
        }

        foreach ($total5Rs as $index => $total){
            $login_arr[$total->purchase_date][1] = isset($total->total) ? $total->total : 0;
        }

        foreach ($total7Rs as $index => $total){
            $login_arr[$total->purchase_date][2] = isset($total->total) ? $total->total : 0;
        }

        foreach ($total30Rs as $index => $total){
            $login_arr[$total->purchase_date][3] = isset($total->total) ? $total->total : 0;
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        return view('admin.users.userRateActive.index',compact('data', 'clientType', 'login_arr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
