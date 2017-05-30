<?php

namespace App\Http\Controllers\Admin\Others;

use App\LogWeb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class LogWebController extends Controller
{
    public function index(Request $request){

        $ip = \Request::get('ip');
        $refer = \Request::get('refer');
        $platform = \Request::get('platform');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $query = LogWeb::query();
        if($ip != ''){
            $query->where('ip','LIKE','%'.$ip.'%');
        }

        if($refer != ''){
            $query->where('refer','LIKE','%'.$refer.'%');
        }

        if($platform != ''){
            $query->where('platform','LIKE','%'.$platform.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('id', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.others.logWeb.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

}
