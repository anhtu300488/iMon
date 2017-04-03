<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\GiftCode;
use App\GiftEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftCodeController extends Controller
{
    public function index(Request $request){

        $userName = \Request::get('userName');

        $giftEvent = GiftEvent::pluck('eventName', 'giftEventId');

        $query = GiftCode::query();
        if($userName != ''){
            $query->where('userName','LIKE','%'.$userName.'%');
        }
        $data = $query->orderBy('userName')->paginate(10);

        return view('admin.moneyGame.giftCode.index',compact('data', 'giftEvent'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        $giftEventId = GiftEvent::pluck('eventName', 'giftEventId');
        return view('admin.moneyGame.giftCode.create', compact('giftEventId'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'giftEventId' => 'required',
            'userName' => 'required',
            'userId' => 'required',
            'expiredTime' => 'required',
            'description' => 'required'
        ]);


        $input = $request->all();
        $input['expiredTime'] = date('Y-m-d',strtotime($request->get('expiredTime')));
        GiftCode::create($input);

        return redirect()->route('giftCode.index')
            ->with('success','Add Gift Code successfully');
    }

    public function edit($id){
        $giftCode = GiftCode::find($id);
        $giftEventId = GiftEvent::pluck('eventName', 'giftEventId');
        return view('admin.moneyGame.giftCode.edit',compact('giftEventId','giftCode'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'giftEventId' => 'required',
            'userName' => 'required',
            'userId' => 'required',
            'expiredTime' => 'required',
            'description' => 'required'
        ]);

        $giftCode = GiftCode::find($id);
        $giftCode->giftEventId = $request->input('giftEventId');
        $giftCode->userName = $request->input('userName');
        $giftCode->userId = $request->input('userId');
        $giftCode->expiredTime = date('Y-m-d',strtotime($request->get('expiredTime')));
        $giftCode->description = $request->input('description');
        $giftCode->save();

        return redirect()->route('giftCode.index')
            ->with('success','Gift Code updated successfully');
    }

    public function destroy($id){
        GiftCode::find($id)->delete();
        return redirect()->route('giftCode.index')
            ->with('success','Gift Code deleted successfully');
    }
}
