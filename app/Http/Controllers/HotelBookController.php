<?php

namespace App\Http\Controllers;

use App\Models\HotelBook;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HotelBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $hBooks = HotelBook::with('guest', 'room')->get();
        return response()->json($hBooks);
    }


    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_of_people' => 'required|integer|min:1',
        ]);

        $hotelBook = new HotelBook();
        $hotelBook->room_id = $request->input('room_id');
        $hotelBook->guest_id = $request->input('guest_id');
        $hotelBook->check_in_date = $request->input('check_in_date');
        $hotelBook->check_out_date = $request->input('check_out_date');
        $hotelBook->num_of_people = $request->input('num_of_people');

        $checkIn = Carbon::parse($hotelBook->check_in_date);
        $checkOut = Carbon::parse($hotelBook->check_out_date);
        $daysDifference = $checkIn->diffInDays($checkOut);

        $room = Room::find($hotelBook->room_id);
        $hotelBook->price = $daysDifference * $room->price;

        $hotelBook->save();

        return response()->json($hotelBook);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}