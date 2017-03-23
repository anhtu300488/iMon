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
}
