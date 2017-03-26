<?php

namespace App\Http\Controllers\Admin\Others;

use App\LogWeb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogWebController extends Controller
{
    public function index(Request $request){

        $ip = \Request::get('ip');
        $refer = \Request::get('refer');
        $platform = \Request::get('platform');

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
        $data = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.others.logWeb.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

}
