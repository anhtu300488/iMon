<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\PurchaseMoneyMissing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseMoneyController extends Controller
{
    public function index(Request $request){

        $provider = \Request::get('provider');
        $cardValue = \Request::get('cardValue');
        $cardPin = \Request::get('cardPin');
        $userId = \Request::get('userId');

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        $query = PurchaseMoneyMissing::query();
        if($provider != ''){
            $query->where('provider','LIKE','%'.$provider.'%');
        }

        if($cardValue != ''){
            $query->where('cardValue','LIKE','%'.$cardValue.'%');
        }

        if($cardPin != ''){
            $query->where('cardPin','LIKE','%'.$cardPin.'%');
        }

        $query->where($matchThese);

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.moneyGame.purchaseMoney.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
