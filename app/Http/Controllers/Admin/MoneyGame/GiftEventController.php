<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\GiftEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class GiftEventController extends Controller
{
    public function index(Request $request){

        $eventName = \Request::get('eventName');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $query = GiftEvent::query();
        if($eventName != ''){
            $query->where('eventName','LIKE','%'.$eventName.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('eventName')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.moneyGame.giftEvent.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.moneyGame.giftEvent.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'eventName' => 'required|max:250',
            'description' => 'max:250'
        ]);


        $input = $request->all();
        $input['expiredTime'] = date('Y-m-d',strtotime($request->get('expiredTime')));
        GiftEvent::create($input);

        return redirect()->route('eventGift.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $eventGift = GiftEvent::find($id);

        return view('admin.moneyGame.giftEvent.edit',compact('eventGift'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'eventName' => 'required|max:250',
            'description' => 'max:250'
        ]);

        $giftEvent = GiftEvent::find($id);
        $giftEvent->eventName = $request->input('eventName');
        $giftEvent->cashValue = $request->input('cashValue');
        $giftEvent->goldValue = $request->input('goldValue');
        $giftEvent->expiredTime = date('Y-m-d',strtotime($request->get('expiredTime')));
        $giftEvent->description = $request->input('description');
        $giftEvent->save();

        return redirect()->route('eventGift.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        GiftEvent::find($id)->delete();
        return redirect()->route('eventGift.index')
            ->with('message','Deleted Successfully');
    }
}
