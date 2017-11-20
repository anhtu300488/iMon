<?php

namespace App\Http\Controllers\Admin\Gateway;
use App\Provider;
use App\Gate\ChargingAgent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ChargingAgentController  extends Controller
{
    public function index(Request $request){
        $description = \Request::get('description');
        $userId = \Request::get('userId');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $matchThese = [];
        $provider = \Request::get('provider');

        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        $query = ChargingAgent::query();
        if($provider != ''){
            $query->where('providerCode','=', $provider);
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);
        $providerArr = Provider::pluck('description', 'code');
        return view('admin.gate.chargingAgent.index',compact('data', 'providerArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
