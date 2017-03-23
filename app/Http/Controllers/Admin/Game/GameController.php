<?php

namespace App\Http\Controllers\Admin\Game;

use App\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $data = $query->orderBy('gameId', 'desc')->paginate(10);

        return view('admin.game.game.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
