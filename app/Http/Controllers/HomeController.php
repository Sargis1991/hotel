<?php

namespace App\Http\Controllers;

use App\Http\Actions\RoomAction;
use App\Models\ReservedDays;
use App\Models\Room;
use App\Models\UserRoom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with('rooms',Room::orderBy('created_at', 'desc')->paginate(12));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function client(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('client')->with('rooms',Room::orderBy('created_at', 'desc')->paginate(12));
    }


    /**
     * @throws ValidationException
     */
    public  function reserve (Room $room,RoomAction $roomAction): \Illuminate\Http\RedirectResponse
    {

        $this->validateRequest();

        if(gettype($roomAction->handler($room->id))==='string'){
            return back()->with('error',$roomAction->handler($room->id).'days are reserved');
        }

        DB::beginTransaction();
        try{

           $row = UserRoom::create([
                'user_id'=>auth()->user()->id,
                'room_id'=>$room->id,
                'from' =>\Carbon\Carbon::parse(\request('from'))->timestamp,
                'to' =>\Carbon\Carbon::parse(\request('to'))->timestamp
            ]);

            ReservedDays::insert($roomAction->handler($room->id,$row->id));

            DB::commit();

            return back()->with('success','Reservation is submitted');
        }
        catch(\Exception $exception) {

            DB::rollBack();
            return back()->with('error','Something went wrong,please try again');
        }

    }

    /**
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function cancel ($id): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try{
            ReservedDays::where('order_id',$id)->delete();

            UserRoom::findOrFail($id)->delete();

            DB::commit();

            return back()->with('success','Reservation is cancelled');
        }
        catch(\Exception $exception) {
            DB::rollBack();
            return back()->with('error','Something went wrong,please try again');
        }
    }


    /**
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function change ($id,$room_id,RoomAction $roomAction): \Illuminate\Http\RedirectResponse
    {
        $this->validateRequest();

        if(gettype($roomAction->handler($room_id))==='string'){
            return back()->with('error',$roomAction->handler($room_id).'days are reserved');
        }

        DB::beginTransaction();
        try{

        UserRoom::findOrFail($id)->update([
            'from' =>\Carbon\Carbon::parse(\request('from'))->timestamp,
            'to' =>\Carbon\Carbon::parse(\request('to'))->timestamp
        ]);

        ReservedDays::where('order_id',$id)->delete();

        ReservedDays::insert($roomAction->handler($room_id,$id));

            DB::commit();

            return back()->with('success','Reservation is changed');
        }
        catch(\Exception $exception) {
            DB::rollBack();
            return back()->with('error','Something went wrong,please try again');
        }



    }

    /**
     * @return void
     * @throws ValidationException
     */
    private function validateRequest(): void
    {
        Validator::make(\request()->all(), [
            'from' => 'required|date_format:m/d/Y|after:'.Carbon::now()->format('m/d/Y'),
            'to' => 'required|date_format:m/d/Y|after:'.Carbon::now()->format('m/d/Y'),
        ])->validate();
    }
}
