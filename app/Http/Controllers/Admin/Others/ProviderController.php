<?php

namespace App\Http\Controllers\Admin\Others;

use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    public function index(Request $request){

        $code = \Request::get('code');
        $description = \Request::get('description');

        $query = Provider::query();
        if($code != ''){
            $query->where('code','LIKE','%'.$code.'%');
        }

        if($description != ''){
            $query->where('description','LIKE','%'.$description.'%');
        }
        $data = $query->orderBy('id')->paginate(10);

        return view('admin.others.telco.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        return view('admin.others.telco.create');
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
        Provider::create($input);

        return redirect()->route('telco.index')
            ->with('success','Add Gift Event successfully');
    }

    public function edit($id){
        $eventGift = Provider::find($id);

        return view('admin.others.telco.edit',compact('eventGift'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'eventName' => 'required',
            'cashValue' => 'required',
            'goldValue' => 'required',
            'expiredTime' => 'required',
            'description' => 'required'
        ]);

        $giftEvent = Provider::find($id);
        $giftEvent->eventName = $request->input('eventName');
        $giftEvent->cashValue = $request->input('cashValue');
        $giftEvent->goldValue = $request->input('goldValue');
        $giftEvent->expiredTime = date('Y-m-d',strtotime($request->get('expiredTime')));
        $giftEvent->description = $request->input('description');
        $giftEvent->save();

        return redirect()->route('telco.index')
            ->with('success','Gift Event updated successfully');
    }

    public function destroy($id){
        Provider::find($id)->delete();
        return redirect()->route('telco.index')
            ->with('success','Gift Event deleted successfully');
    }
}
