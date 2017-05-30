<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\CardProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class CardProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $providerCode = \Request::get('providerCode');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $query = CardProvider::query();

        if($providerCode != ''){
            $query->where('providerCode','LIKE','%'.$providerCode.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('providerId', 'desc')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.moneyGame.cardProvider.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
