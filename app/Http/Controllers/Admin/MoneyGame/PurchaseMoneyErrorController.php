<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\Provider;
use App\PurchaseMoneyError;
use App\PurchaseMoneyMissing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class PurchaseMoneyErrorController extends Controller
{
    public function index(Request $request){

        $provider = \Request::get('provider');
        $cardSerial = \Request::get('cardSerial');
        $cardPin = \Request::get('cardPin');
        $userId = \Request::get('userId');
        $timeRequest = \Request::get('timeRequest') ? explode(" - ", \Request::get('timeRequest')) : null;
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $providerArr = Provider::pluck('description', 'code');

        $query = PurchaseMoneyError::query();
        if($userId != ''){
            $query->where('userId','=',$userId);
        }

        if($provider != ''){
            $query->where('provider','=', $provider);
        }

        if($cardSerial != ''){
            $query->where('cardValue','=',$cardSerial);
        }

        if($cardPin != ''){
            $query->where('cardPin','=',$cardPin);
        }

        if($timeRequest != ''){
            $startDateCharge = $timeRequest[0];

            $endDateCharge = $timeRequest[1];

            if($startDateCharge != '' && $endDateCharge != ''){
                $start = date("Y-m-d 00:00:00",strtotime($startDateCharge));
                $end = date("Y-m-d 23:59:59",strtotime($endDateCharge));
                $query->whereBetween('requestedTime',[$start,$end]);
            }
        }

        $query->where('active','=', 1);

        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('requestedTime', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.moneyGame.purchaseMoneyError.index',compact('data','providerArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function purchaseMoney(Request $request){
        $this->validate($request, [
            'purchaseErrorId' => 'required|integer',
            'cardSerial' => 'required|unique:purchase_money_missing',
            'cardPin' => 'required|unique:purchase_money_missing',
            'cardValue' => 'required',
            'provider' => 'required',
            'userId' => 'required'
        ]);
        $id = Input::get('purchaseErrorId');
        $cardSerial = Input::get('cardSerial');
        $cardPin = Input::get('cardPin');
        $cardValue = Input::get('cardValue');
        $provider = Input::get('provider');
        $userId = Input::get('userId');

        $input = $request->all();
        $input['admin_id'] = Auth::user()->id;
        $input['cardSerial'] = $cardSerial;
        $input['cardPin'] = $cardPin;
        $input['cardValue'] = $cardValue;
        $input['provider'] = $provider;
        $input['userId'] = $userId;
        PurchaseMoneyMissing::create($input);

        PurchaseMoneyError::where('purchaseErrorId', $id)->update(['active' => 0]);
        return redirect()->route('errorPurchaseMoney.index')
            ->with('message','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = PurchaseMoneyError::find($id);

        $flight->delete();

        return redirect()->route('errorPurchaseMoney.index')
            ->with('message','Deleted Successfully');
    }
}
