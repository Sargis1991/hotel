<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedDays extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopeReserved($query, $room_id,$from,$to)
    {
        $query->select('day')->where('room_id',$room_id)
            ->whereBetween('day', [$from, $to]);
    }

}
