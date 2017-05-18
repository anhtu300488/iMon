<?php

namespace App\Http\Controllers\Admin\Tool;

use App\GiftCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class GiftCodeController extends Controller
{
    public function index(Request $request){

        $userName = \Request::get('userName');
        $code = \Request::get('code');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $matchThese = [];
        if($code != ''){
            $matchThese['code'] = $code;
        }

        $query = GiftCode::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('userName')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.tool.giftCode.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
