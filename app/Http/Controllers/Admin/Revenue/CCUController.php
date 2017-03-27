<?php

namespace App\Http\Controllers\Admin\Revenue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CCUController extends Controller
{
    public function index(Request $request){
        return view('admin.revenue.ccu.index');
    }
}
