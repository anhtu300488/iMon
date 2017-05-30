<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\GiftCode;
use App\GiftEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class GiftCodeController extends Controller
{
    public function index(Request $request){

        $userName = \Request::get('userName');
        $userId = \Request::get('userId');
        $code = \Request::get('code');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $giftEvent = GiftEvent::pluck('eventName', 'giftEventId');

        $query = GiftCode::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        if($userId != ''){
            $query->where('userId','=',$userId);
        }
        if($code != ''){
            $query->where('code','=',$code);
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('userName')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.moneyGame.giftCode.index',compact('data', 'giftEvent'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        $giftEventId = GiftEvent::pluck('eventName', 'giftEventId');
        return view('admin.moneyGame.giftCode.create', compact('giftEventId'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'giftEventId' => 'required',
            'userName' => 'max:20',
            'userId' => 'required',
            'expiredTime' => 'required',
            'description' => 'max:250'
        ]);


        $input = $request->all();
        $input['expiredTime'] = date('Y-m-d',strtotime($request->get('expiredTime')));
        GiftCode::create($input);

        return redirect()->route('giftCode.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $giftCode = GiftCode::find($id);
        $giftEventId = GiftEvent::pluck('eventName', 'giftEventId');
        return view('admin.moneyGame.giftCode.edit',compact('giftEventId','giftCode'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'giftEventId' => 'required',
            'userName' => 'max:20',
            'userId' => 'required',
            'expiredTime' => 'required',
            'description' => 'max:250'
        ]);

        $giftCode = GiftCode::find($id);
        $giftCode->giftEventId = $request->input('giftEventId');
        $giftCode->userName = $request->input('userName');
        $giftCode->userId = $request->input('userId');
        $giftCode->expiredTime = date('Y-m-d',strtotime($request->get('expiredTime')));
        $giftCode->description = $request->input('description');
        $giftCode->save();

        return redirect()->route('giftCode.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        GiftCode::find($id)->delete();
        return redirect()->route('giftCode.index')
            ->with('message','Deleted Successfully');
    }
}
