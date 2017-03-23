<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\GiftCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftCodeController extends Controller
{
    public function index(Request $request){

        $userName = \Request::get('userName');

        $query = GiftCode::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $data = $query->orderBy('userName')->paginate(10);

        return view('admin.moneyGame.giftCode.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
