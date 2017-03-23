<?php

namespace App\Http\Controllers\Admin\MoneyGame;

use App\CardProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $data = $query->orderBy('providerId', 'desc')->paginate(10);

        return view('admin.moneyGame.cardProvider.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
