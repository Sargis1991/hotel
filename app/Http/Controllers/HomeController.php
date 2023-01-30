<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
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
    public  function reserve (Room $room): \Illuminate\Http\RedirectResponse
    {

        $this->validateRequest();

        DB::beginTransaction();
        try{
            $room->update(['status'=>true]);

            auth()->user()->rooms()->attach($room->id, ['day' =>\Carbon\Carbon::parse(\request('date'))->timestamp ]);

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
    public  function cancel (Room $room): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try{
            $room->update(['status'=>false]);

            auth()->user()->rooms()->detach($room->id);

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
    public function change (Room $room): \Illuminate\Http\RedirectResponse
    {
        $this->validateRequest();

        auth()->user()->rooms()->updateExistingPivot($room->id,['day' =>\Carbon\Carbon::parse(\request('date'))->timestamp ] );

        return back()->with('success','Reservation is changed');

    }

    /**
     * @return void
     * @throws ValidationException
     */
    private function validateRequest(): void
    {
        Validator::make(\request()->all(), [
            'date' => 'required|date_format:m/d/Y',
        ])->validate();
    }
}
