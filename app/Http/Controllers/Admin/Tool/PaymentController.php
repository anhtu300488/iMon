<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Cp;
use App\CpPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $userId = \Request::get('userId');
        $description = \Request::get('description');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $matchThese = [];
        $query = Cp::query();

        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('cpId','desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.tool.payment.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
    public function edit($id){
        $cp = Cp::find($id);
        $cp_payment = CpPayment::findByCpId($id);
        $list_charge = array();
        $list_topup = array();
        foreach ($cp_payment as $index => $payment){
            if($payment->type == 1){
                $list_charge[$payment->name] =$payment->url;
            }else {
                $list_topup[$payment->name] =$payment->url;

            }
        }
//        $list_charge = array(
//            "PAYGATE" => "http://127.0.0.1:8080/api.php/payimon",
//            "SANTHE" => "http://127.0.0.1:8080/api.php/santhe"
//        );
//        $list_topup = array(
//            "CONGGACHTHE" => "http://127.0.0.1:8080/api.php/buycardimon",
//            "CONGGACHTHE2" => "http://127.0.0.1:8080/api.php/buycardimon"
//        );
        return view('admin.tool.payment.edit',compact('cp', "list_charge", "list_topup"));
    }
    public function update(Request $request, $id){
        $cp_payment = CpPayment::findByCpId($id);
        $list_charge = array();
        $list_topup = array();
        foreach ($cp_payment as $index => $payment){
            if($payment->type == 1){
                $list_charge[$payment->name] =$payment->url;
            }else {
                $list_topup[$payment->name] =$payment->url;

            }
        }
        $this->validate($request, [
            'cpName' => 'required',
            'topupUri' => 'required|in:' .  implode(',', array_keys($list_topup)),
            'chargingUri' => 'required|in:' .implode(',', array_keys($list_charge))]);
        $cp = Cp::find($id);
        $cp->cpName = $request->input('cpName');
        $cp->topupUri = $list_topup[$request->input('topupUri')];
        $cp->chargingUri = $list_charge[$request->input('chargingUri')];
        $cp->save();

        return redirect()->route('tool.payment')
            ->with('message','Updated Successfully');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}
