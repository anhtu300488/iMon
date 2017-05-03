<?php

namespace App\Http\Controllers\Admin\Others;

use App\WebContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class WebContentController extends Controller
{
    public function index(Request $request){

        $title = \Request::get('title');
        $content = \Request::get('content');
        $type = \Request::get('type');

        $typeArr = array('' => '---Tất cả---', 0 => 'Tin Tức', 1 => 'Sự Kiện', 2 => 'Giới Thiệu', 3 => 'Hỗ Trợ', 4 => 'Luật game', 5 => 'Thông báo');

        $query = WebContent::query();
        $matchThese = [];
        if($type != ''){
            $matchThese['type'] = $type;
        }

        if($title != ''){
            $query->where('title','LIKE','%'.$title.'%');
        }

        if($content != ''){
            $query->where('content','LIKE','%'.$content.'%');
        }
        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.others.webContent.index',compact('data', 'typeArr'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(){
        $typeArr = array(0 => 'Tin Tức', 1 => 'Sự Kiện', 2 => 'Giới Thiệu', 3 => 'Hỗ Trợ', 4 => 'Luật game');
        return view('admin.others.webContent.create', compact('typeArr'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|max:256',
            'keywords' => 'max:256',
            'description' => 'max:512',
            'content' => 'required|max:40000'
        ]);


        $input = $request->all();
        WebContent::create($input);

        return redirect()->route('webContent.index')
            ->with('message','Add Successfully');
    }

    public function edit($id){
        $webContent = WebContent::find($id);
        $typeArr = array(0 => 'Tin Tức', 1 => 'Sự Kiện', 2 => 'Giới Thiệu', 3 => 'Hỗ Trợ', 4 => 'Luật game');

        return view('admin.others.webContent.edit',compact('webContent', 'typeArr'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required|max:256',
            'keywords' => 'max:256',
            'description' => 'max:512',
            'content' => 'required|max:40000'
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
            ->with('message','Updated Successfully');
    }

    public function destroy($id){
        WebContent::find($id)->delete();
        return redirect()->route('webContent.index')
            ->with('message','Deleted Successfully');
    }
}
