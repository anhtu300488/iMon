<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';

    public $timestamps = false;

    protected $primaryKey = 'roomId';

    protected $fillable = ['gameId', 'roomName', 'vipRoom', 'minCash', 'minGold', 'minLevel', 'roomCapacity', 'playerSize', 'minBet', 'tax', 'maxRoomplay', 'permanentRoomPlay', 'kickLimit', 'startTime', 'endTime'];
}
