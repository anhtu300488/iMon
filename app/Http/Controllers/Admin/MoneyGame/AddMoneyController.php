<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\AddMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddMoneyController extends Controller
{
    public function index(Request $request){

        $description = \Request::get('description');
        $userId = \Request::get('userId');

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        $query = AddMoney::query();
        if($description != ''){
            $query->where('description','LIKE','%'.$description.'%');
        }

        $query->where($matchThese);

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.moneyGame.addMoney.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
