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

        $query = CardProvider::query();

        if($providerCode != ''){
            $query->where('providerCode','LIKE','%'.$providerCode.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('providerId', 'desc')->paginate($perPage);

        return view('admin.moneyGame.cardProvider.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }
}
