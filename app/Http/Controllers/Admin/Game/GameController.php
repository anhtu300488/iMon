<?php

namespace App\Http\Controllers\Admin\Game;

use App\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = \Request::get('name');
        $description = \Request::get('description');
        $help = \Request::get('help');
        $status = \Request::get('status');
        $page = \Request::get('page') ? \Request::get('page') : 1;

        $matchThese = [];
        if($status != ''){
            $matchThese['status'] = $status;
        }

        $query = Game::query();

        if($name != ''){
            $query->where('name','LIKE','%'.$name.'%');
        }

        if($description != ''){
            $query->where('description','LIKE','%'.$description.'%');
        }

        if($help != ''){
            $query->where('help','LIKE','%'.$help.'%');
        }

        $query->where($matchThese);
        $perPage = Config::get('app_per_page') ? Config::get('app_per_page') : 100;
        $startLimit = $perPage * ($page - 1);
        $endLimit = $perPage * $page;
        $data = $query->orderBy('gameId', 'desc')->limit($startLimit,$endLimit)->paginate($perPage);

        return view('admin.game.game.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function edit($id){
        $game = Game::find($id);
        return view('admin.game.game.edit',compact('game'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'description' => 'required'
        ]);

        $game = Game::find($id);
        $game->description = $request->input('description');
        $game->save();

        return redirect()->route('manageGame.index')
            ->with('message','Updated Successfully');
    }
}
