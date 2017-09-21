<?php

namespace App\Http\Controllers\Admin\System;

use App\taixiuProphecy;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TaiXiuController extends Controller
{
    public function create(){
        return view('admin.system.taixiu.create');
    }

    public function store(Request $request){

        $this->validate($request, [
            'isGreat' => 'required|integer'
        ]);

        $input = $request->all();
        $input['admin_id'] = Auth::user()->id;

        taixiuProphecy::create($input);

        return redirect()->route('system.taixiu.create')
            ->with('message','Add Successfully');
    }
}
