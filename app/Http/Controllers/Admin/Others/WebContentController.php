<?php

namespace App\Http\Controllers\Admin\Others;

use App\WebContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebContentController extends Controller
{
    public function index(Request $request){

        $title = \Request::get('title');
        $content = \Request::get('content');
        $status = \Request::get('status');

        $query = WebContent::query();
        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        if($title != ''){
            $query->where('title','LIKE','%'.$title.'%');
        }

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }
        $query->where($matchThese);
        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.others.webContent.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        return view('admin.others.webContent.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'keywords' => 'required',
            'description' => 'required',
            'content' => 'required',
            'image' => 'required',
            'type' => 'required',
            'status' => 'required',
            'is_hot' => 'required'
        ]);


        $input = $request->all();
        WebContent::create($input);

        return redirect()->route('webContent.index')
            ->with('success','Add Web content successfully');
    }

    public function edit($id){
        $webContent = WebContent::find($id);

        return view('admin.others.webContent.edit',compact('webContent'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required',
            'keywords' => 'required',
            'description' => 'required',
            'content' => 'required',
            'image' => 'required',
            'type' => 'required',
            'status' => 'required',
            'is_hot' => 'required'
        ]);

        $giftEvent = WebContent::find($id);
        $giftEvent->title = $request->input('title');
        $giftEvent->keywords = $request->input('keywords');
        $giftEvent->description = $request->input('description');
        $giftEvent->content = $request->get('content');
        $giftEvent->type = $request->input('type');
        $giftEvent->status = $request->input('status');
        $giftEvent->is_hot = $request->input('is_hot');
        $giftEvent->save();

        return redirect()->route('webContent.index')
            ->with('success','Gift Event updated successfully');
    }

    public function destroy($id){
        WebContent::find($id)->delete();
        return redirect()->route('webContent.index')
            ->with('success','Gift Event deleted successfully');
    }
}
