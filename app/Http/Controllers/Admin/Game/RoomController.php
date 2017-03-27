<?php

namespace App\Http\Controllers\Admin\Game;

use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gameId = \Request::get('gameId');

        $roomName = \Request::get('roomName');

        $matchThese = [];
        if($gameId != ''){
            $matchThese['gameId'] = $gameId;
        }

        $query = Room::query();

        if($roomName != ''){
            $query->where('content','LIKE','%'.$roomName.'%');
        }

        $query->where($matchThese);

        $data = $query->orderBy('startTime', 'desc')->paginate(10);

        return view('admin.game.room.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(){
        return view('admin.game.room.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'gameId' => 'required|integer',
            'roomName' => 'required',
            'vipRoom' => 'required|integer',
            'minCash' => 'required|integer',
            'minGold' => 'required|integer',
            'minLevel' => 'required|integer',
            'roomCapacity' => 'required|integer',
            'playerSize' => 'required|integer',
            'minBet' => 'required|integer',
            'tax' => 'required|integer',
            'maxRoomplay' => 'required|integer',
            'permanentRoomPlay' => 'required|integer',
            'kickLimit' => 'required|integer',
            'startTime' => 'required',
            'endTime' => 'required',
        ]);

        $input = $request->all();
        $input['startTime'] = date('Y-m-d',strtotime($request->get('startTime')));
        $input['endTime'] = date('Y-m-d',strtotime($request->get('endTime')));

        Room::create($input);

        return redirect()->route('room.index')
            ->with('success','Add room successfully');
    }

    public function edit($id){
        $room = Room::find($id);

        return view('admin.game.room.edit',compact('room'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'gameId' => 'required|integer',
            'roomName' => 'required',
            'vipRoom' => 'required|integer',
            'minCash' => 'required|integer',
            'minGold' => 'required|integer',
            'minLevel' => 'required|integer',
            'roomCapacity' => 'required|integer',
            'playerSize' => 'required|integer',
            'minBet' => 'required|integer',
            'tax' => 'required|integer',
            'maxRoomplay' => 'required|integer',
            'permanentRoomPlay' => 'required|integer',
            'kickLimit' => 'required|integer',
            'startTime' => 'required',
            'endTime' => 'required',
        ]);

        $room = Room::find($id);
        $room->gameId = $request->input('gameId');
        $room->roomName = $request->input('roomName');
        $room->vipRoom = $request->input('vipRoom');
        $room->minCash = $request->input('minCash');
        $room->minGold = $request->input('minGold');
        $room->minLevel = $request->input('minLevel');
        $room->roomCapacity = $request->input('roomCapacity');
        $room->playerSize = $request->input('playerSize');
        $room->minBet = $request->input('minBet');
        $room->tax = $request->input('tax');
        $room->maxRoomplay = $request->input('maxRoomplay');
        $room->permanentRoomPlay = $request->input('permanentRoomPlay');
        $room->kickLimit = $request->input('kickLimit');
        $room->startTime = date('Y-m-d',strtotime($request->get('startTime')));
        $room->endTime = date('Y-m-d',strtotime($request->get('endTime')));
        $room->save();

        return redirect()->route('room.index')
            ->with('success','Message updated successfully');
    }

    public function destroy($id){
        Room::find($id)->delete();
        return redirect()->route('room.index')
            ->with('success','Room deleted successfully');
    }
}
