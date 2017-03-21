<?php

namespace App\Http\Controllers\Admin\Tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SendEmailController extends Controller
{
    public function create(){
        return view('admin.tool.sendEmail.create');
    }

    public function store(Request $request){
        var_dump($request->all());die;
        return view('admin.tool.sendEmail.create');
    }
}
