<?php

namespace App\Http\Controllers\Admin\Gateway;
use App\Provider;
use App\Gate\ChargingAgentLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ChargingAgentlogController  extends Controller
{
    public function index(Request $request){
        $description = \Request::get('description');
        $cardPin = \Request::get('cardPin');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $matchThese = [];

//        $query = ChargingAgentLog::query();
        $query = DB::table('charging_agent_log as p');
        $query->select('charging_agent.name as agent_name');
        $query->join('charging_agent', function($join)
        {
            $join->on('charging_agent.agentId', '=', 'p.agentId');

        });
        if($cardPin != ''){
            $query->where('cardPin','=', $cardPin);
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);
        return view('admin.gate.chargingAgentLog.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
