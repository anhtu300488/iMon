<?php

namespace App\Http\Controllers\Admin\Tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopGameController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.tool.topGame.index');
    }
}
