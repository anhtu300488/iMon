<?php

namespace App\Http\Controllers\Admin\Others;

use App\ClientType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ClientTypeController extends Controller
{
    public function index(Request $request){

        $code = \Request::get('code');
        $name = \Request::get('name');
        $page = \Request::get('page') ? \Request::get('page') : 1;
        $query = ClientType::query();
        if($code != ''){
            $query->where('code','LIKE','%'.$code.'%');
        }

        if($name != ''){
            $query->where('name','LIKE','%'.$code.'%');
        }
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('clientId')->offset($startLimit)->limit($perPage)->paginate($perPage);

        return view('admin.others.os.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        return view('admin.others.os.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ]);


        $input = $request->all();
        ClientType::create($input);

        return redirect()->route('clientType.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $clientType = ClientType::find($id);

        return view('admin.others.os.edit',compact('clientType'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ]);

        $clientType = ClientType::find($id);
        $clientType->code = $request->input('code');
        $clientType->name = $request->input('name');
        $clientType->save();

        return redirect()->route('clientType.index')
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        ClientType::find($id)->delete();
        return redirect()->route('clientType.index')
            ->with('message','Deleted successfully');
    }
}
