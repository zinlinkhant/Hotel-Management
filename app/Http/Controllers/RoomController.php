<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rooms = Room::all();
        return response()->json($rooms);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {

        $room = new Room();
        $room->number = $request->input('number');
        $room->price = $request->input('price');
        $room->name = $request->input('name');
        $room->active = $request->input('active', true); // Default to true if not provided
        $room->save();

        return $room;
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