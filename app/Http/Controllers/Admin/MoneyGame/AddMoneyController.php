<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\AddMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AddMoneyController extends Controller
{
    public function index(Request $request){

        $description = \Request::get('description');
        $userId = \Request::get('userId');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        $query = AddMoney::query();
        if($description != ''){
            $query->where('description','LIKE','%'.$description.'%');
        }

        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.moneyGame.addMoney.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.moneyGame.addMoney.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'userId' => 'required',
            'addCash' => 'required',
//            'addGold' => 'required',
            'description' => 'required'
        ]);


        $input = $request->all();
        $input['admin_id'] = Auth::user()->id;
        AddMoney::create($input);

        return redirect()->route('addMoney.index')
            ->with('message','Add Successfully');
    }

}
