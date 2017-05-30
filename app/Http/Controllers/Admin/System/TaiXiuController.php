<?php

namespace App\Http\Controllers\Admin\System;

use App\taixiuProphecy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        taixiuProphecy::create($input);

        return redirect()->route('system.taixiu.create')
            ->with('message','Add Successfully');
    }
}
