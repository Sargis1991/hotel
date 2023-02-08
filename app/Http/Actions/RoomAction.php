<?php

namespace App\Http\Actions;

use Closure;
use App\Models\UserRoom;

class RoomAction
{
    public function handler ($room_id) {

        $from = \Carbon\Carbon::parse(\request('from'))->timestamp;
        $to = \Carbon\Carbon::parse(\request('to'))->timestamp;

        return $count =UserRoom::where('room_id',$room_id)
            ->where(function ($query) use ($from,$to){
                $query->where('from','>',$from)->where('from','<',$to);
            })->orWhere(function ($query) use ($from,$to){
                $query->where('to','>',$from)->where('to','<',$to);
            })->count();

    }



}
