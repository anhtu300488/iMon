<?php

namespace App\Http\Controllers\Admin\Tool;

use App\GiftCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftCodeController extends Controller
{
    public function index(Request $request){

        $userName = \Request::get('userName');
        $code = \Request::get('code');

        $matchThese = [];
        if($code != ''){
            $matchThese['code'] = $code;
        }

        $query = GiftCode::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $query->where($matchThese);
        $data = $query->orderBy('userName')->paginate(10);

        return view('admin.tool.giftCode.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
