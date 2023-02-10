<?php

namespace App\Http\Actions;

use App\Models\ReservedDays;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class RoomAction
{
    private string $from;

    private string $to;

    public function __construct()
    {
        $this->from = Carbon::parse(\request('from'))->format('Y-m-d');
        $this->to = Carbon::parse(\request('to'))->subDays(1)->format('Y-m-d');
    }

    /**
     * @param int $room_id
     * @param int|null $order_id
     * @return array|mixed
     */

    public function handler ( int $room_id,int $order_id=null): mixed
    {

        if($this->checker($room_id)) return $this->checker($room_id);

        return $this->buildQuery($order_id,$room_id);
    }

    /**
     * @param int|null $order_id
     * @param int $room_id
     * @return array
     */
    private function buildQuery(?int $order_id, int $room_id): array
    {
        $query = [];

        $ranges = CarbonPeriod::create($this->from, $this->to)->toArray();

        foreach ($ranges as $item){
            $query[] = ['order_id' => $order_id, 'room_id' => $room_id, 'day' => $item];
        }

        return $query;
    }


    /**
     * @param int $room_id
     * @return string|bool
     */
    private function checker  (int $room_id): string|bool
    {

      $query =ReservedDays::select('day')->where('room_id',$room_id)
            ->whereBetween('day', [$this->from, $this->to]);

      if($query->count()>0)
      {
          $output='';
          foreach ($query->get() as $day){
              $output .= '('.$day->day.') ';
          }
          return $output;
      }

      return false;
    }



}
