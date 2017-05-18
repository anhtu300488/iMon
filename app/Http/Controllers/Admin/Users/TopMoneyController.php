<?php

namespace App\Http\Controllers\Admin\Users;

use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class TopMoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = \Request::get('type');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $typeArr = array('' => '---Tất cả---', 1 => 'Mon');

        $query = UserReg::query();

        if ($type == 2){
            $query->orderBy('gold', 'desc');
        }
        $query->orderBy('cash', 'desc');
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.users.topMoney.index',compact('data', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
