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

    public function create(){
        $provider = array("VTT" => "Viettel", "VMS" => "Mobifone" ,"VNP" => "Vinaaphone",
            "VNMB" => "VietNam Mobile", "MGC" => "MegaCard" );
        $toCash = array(1 => "Ken", 0 => "Xu" );
        return view('admin.moneyGame.purchaseMoney.create', compact('provider', 'toCash'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'provider' => 'required',
            'cardValue' => 'required',
            'userId' => 'required',
            'cardPin' => 'required',
            'cardSerial' => 'required',
            'toCash' => 'required'
        ]);

        $input = $request->all();
        PurchaseMoneyMissing::create($input);

        return redirect()->route('purchaseMoney.index')
            ->with('success','Add PurchaseMoneyMissing successfully');
    }

    public function edit($id){
        $purchaseMoneyMissing = PurchaseMoneyMissing::find($id);
        $provider = array("VTT" => "Viettel", "VMS" => "Mobifone" ,"VNP" => "Vinaaphone",
            "VNMB" => "VietNam Mobile", "MGC" => "MegaCard" );
        $toCash = array(1 => "Ken", 0 => "Xu" );
        return view('admin.moneyGame.purchaseMoney.edit',compact('provider', 'toCash', 'purchaseMoneyMissing'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'provider' => 'required',
            'cardValue' => 'required',
            'userId' => 'required',
            'cardPin' => 'required',
            'cardSerial' => 'required',
            'toCash' => 'required'
        ]);

        $purchaseMoneyMissing = PurchaseMoneyMissing::find($id);
        $purchaseMoneyMissing->provider = $request->input('provider');
        $purchaseMoneyMissing->cardValue = $request->input('cardValue');
        $purchaseMoneyMissing->userId = $request->input('userId');
        $purchaseMoneyMissing->cardPin = $request->get('cardPin');
        $purchaseMoneyMissing->cardSerial = $request->input('cardSerial');
        $purchaseMoneyMissing->toCash = $request->input('toCash');
        $purchaseMoneyMissing->save();

        return redirect()->route('purchaseMoney.index')
            ->with('success','Gift Code updated successfully');
    }

    public function destroy($id){
        PurchaseMoneyMissing::find($id)->delete();
        return redirect()->route('purchaseMoney.index')
            ->with('success','Gift Code deleted successfully');
    }
}
