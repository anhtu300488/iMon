<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\PurchaseMoneyMissing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PurchaseMoneyController extends Controller
{
    public function index(Request $request){

        $provider = \Request::get('provider');
        $cardValue = \Request::get('cardValue');
        $cardPin = \Request::get('cardPin');
        $userId = \Request::get('userId');
        $page = \Request::get('page') ? \Request::get('page') : 1;
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
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('created_at', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.moneyGame.purchaseMoney.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        $provider = array("VTT" => "Viettel", "VMS" => "Mobifone" ,"VNP" => "Vinaaphone",
            "VNMB" => "VietNam Mobile", "MGC" => "MegaCard" );
        $toCash = array(1 => "Mon" );
        return view('admin.moneyGame.purchaseMoney.create', compact('provider', 'toCash'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'provider' => 'required',
            'cardValue' => 'required|integer|max:500000',
            'userId' => 'required',
            'cardPin' => 'required|unique:purchase_money_missing|max:20',
            'cardSerial' => 'required|unique:purchase_money_missing|max:20',
            'toCash' => 'required'
        ]);

        $input = $request->all();
        $input['admin_id'] = Auth::user()->id;
        PurchaseMoneyMissing::create($input);

        return redirect()->route('purchaseMoney.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $purchaseMoneyMissing = PurchaseMoneyMissing::find($id);
        $provider = array("VTT" => "Viettel", "VMS" => "Mobifone" ,"VNP" => "Vinaaphone",
            "VNMB" => "VietNam Mobile", "MGC" => "MegaCard" );
        $toCash = array(1 => "Mon" );
        return view('admin.moneyGame.purchaseMoney.edit',compact('provider', 'toCash', 'purchaseMoneyMissing'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'provider' => 'required',
            'cardValue' => 'required|integer|max:500000',
            'userId' => 'required',
            'cardPin' => 'required|unique:purchase_money_missing|max:20',
            'cardSerial' => 'required|unique:purchase_money_missing|max:20',
            'toCash' => 'required'
        ]);

        $purchaseMoneyMissing = PurchaseMoneyMissing::find($id);
        $purchaseMoneyMissing->provider = $request->input('provider');
        $purchaseMoneyMissing->cardValue = $request->input('cardValue');
        $purchaseMoneyMissing->userId = $request->input('userId');
        $purchaseMoneyMissing->cardPin = $request->get('cardPin');
        $purchaseMoneyMissing->cardSerial = $request->input('cardSerial');
        $purchaseMoneyMissing->toCash = $request->input('toCash');
        $purchaseMoneyMissing->admin_id = Auth::user()->id;
        $purchaseMoneyMissing->save();

        return redirect()->route('purchaseMoney.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        PurchaseMoneyMissing::find($id)->delete();
        return redirect()->route('purchaseMoney.index')
            ->with('message','Deleted Successfully');
    }
}
