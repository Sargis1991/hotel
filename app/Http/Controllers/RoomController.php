<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return  view('roomCrud.create')->with('room',new Room());
    }

    /**
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store( Room $room): \Illuminate\Http\RedirectResponse
    {
        $this->validateRequest();

        $room->create(['number'=>\request('number')]);

        return to_route('home')->with('success','Room added successfully');
    }


    /**
     * @param Room $room
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Room $room): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return  view('roomCrud.edit')->with('room',$room);

    }

    /**
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update( Room $room): \Illuminate\Http\RedirectResponse
    {
        $this->validateRequest();

        $room->update(['number'=>\request('number')]);

        return to_route('home')->with('success','Room changed successfully');
    }

    /**
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Room $room): \Illuminate\Http\RedirectResponse
    {
        $room->delete();

        return to_route('home')->with('success','Room deleted successfully');
    }


    /**
     * @throws ValidationException
     */
    private function validateRequest()
    {
        Validator::make(\request()->all(), [
            'number' => 'required|unique:rooms',
        ])->validate();
    }
}
