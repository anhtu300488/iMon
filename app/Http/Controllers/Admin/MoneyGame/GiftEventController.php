<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\GiftEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftEventController extends Controller
{
    public function index(Request $request){

        $eventName = \Request::get('eventName');

        $query = GiftEvent::query();
        if($eventName != ''){
            $query->where('eventName','LIKE','%'.$eventName.'%');
        }
        $data = $query->orderBy('eventName')->paginate(10);

        return view('admin.moneyGame.giftEvent.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
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
            ->with('success','Add Gift Event successfully');
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
            ->with('success','Gift Event updated successfully');
    }

    public function destroy($id){
        GiftEvent::find($id)->delete();
        return redirect()->route('eventGift.index')
            ->with('success','Gift Event deleted successfully');
    }
}
