<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Controllers\Controller;

class TaxController extends Controller
{
    public function index(){

        return view('admin.revenue.tax.index');
    }
}
