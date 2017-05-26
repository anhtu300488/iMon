<?php

namespace App\Http\Controllers\Admin\Tool;

use App\AddMoney;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AddMoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $userId = \Request::get('userId');
        $description = \Request::get('description');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $matchThese = [];
        if($userId != ''){
            $matchThese['userId'] = $userId;
        }

        $query = AddMoney::query();
        if($description != ''){
            $query->where('description','LIKE','%'.$description.'%');
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('id','desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.tool.addMoney.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tool.addMoney.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required|integer',
            'addGold' => 'required|integer',
            'addCash' => 'required|integer'
        ]);

        $addMoney = new AddMoney;

        $addMoney->userId = $request->get('userId');
        $addMoney->addGold = $request->get('addGold');
        $addMoney->addCash = $request->get('addCash');
        $addMoney->description = $request->get('description');
        $addMoney->admin_id = Auth::user()->id;
        $addMoney->status = 1;
        $addMoney->created_at = Carbon::now();
        $addMoney->updated_at = Carbon::now();
        $addMoney->save();

//        $input = $request->all();
//        $input['admin_id'] = Auth::user()->id;
//        $input['status'] = 1;
//        $input['created_at'] = Carbon::now();
//        $input['updated_at'] = Carbon::now();
//
//        $user = AddMoney::create($input);

        return redirect()->route('tool.addMoney')
            ->with('message','Add Successfully');
    }
}
