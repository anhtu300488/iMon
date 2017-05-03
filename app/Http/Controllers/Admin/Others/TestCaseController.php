<?php

namespace App\Http\Controllers\Admin\Others;

use App\GvTestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class TestCaseController extends Controller
{
    public function index(Request $request){

        $eventName = \Request::get('eventName');

        $query = GvTestCase::query();
        if($eventName != ''){
            $query->where('eventName','LIKE','%'.$eventName.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('eventName')->paginate($perPage);

        return view('admin.moneyGame.giftEvent.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.moneyGame.giftEvent.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'eventName' => 'required',
            'cashValue' => 'required',
            'goldValue' => 'required',
            'expiredTime' => 'required',
            'description' => 'required'
        ]);


        $input = $request->all();
        $input['expiredTime'] = date('Y-m-d',strtotime($request->get('expiredTime')));
        GvTestCase::create($input);

        return redirect()->route('eventGift.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $eventGift = GvTestCase::find($id);

        return view('admin.moneyGame.giftEvent.edit',compact('eventGift'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'eventName' => 'required',
            'cashValue' => 'required',
            'goldValue' => 'required',
            'expiredTime' => 'required',
            'description' => 'required'
        ]);

        $giftEvent = GvTestCase::find($id);
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
        GvTestCase::find($id)->delete();
        return redirect()->route('eventGift.index')
            ->with('message','Deleted Successfully');
    }
}
