<?php

namespace App\Http\Controllers\Admin\Others;

use App\ClientType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientTypeController extends Controller
{
    public function index(Request $request){

        $code = \Request::get('code');
        $name = \Request::get('name');

        $query = ClientType::query();
        if($code != ''){
            $query->where('code','LIKE','%'.$code.'%');
        }

        if($name != ''){
            $query->where('name','LIKE','%'.$code.'%');
        }
        $data = $query->orderBy('clientId')->paginate(10);

        return view('admin.others.os.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
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
            ->with('success','Add Client Type successfully');
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
            ->with('success','Client Type updated successfully');
    }

    public function destroy($id){
        ClientType::find($id)->delete();
        return redirect()->route('clientType.index')
            ->with('success','Client Type deleted successfully');
    }
}
