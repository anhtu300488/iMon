<?php

namespace App\Http\Controllers\Admin\Users;

use App\UserReg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopMoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = \Request::get('type');

        $typeArr = array('' => '---Tất cả---', 1 => 'Ken', 2 => 'Xu');

        $query = UserReg::query();

        if ($type == 2){
            $query->orderBy('gold', 'desc');
        }
        $query->orderBy('cash', 'desc');
        $data = $query->paginate(10);

        return view('admin.users.topMoney.index',compact('data', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
