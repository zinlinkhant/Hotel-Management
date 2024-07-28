<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $room->num_of_people = $request->input('num_of_people');
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
    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'number' => 'sometimes|required|integer',
                'price' => 'sometimes|required|integer',
                'name' => 'sometimes|required|string|max:255',
                'num_of_people' => 'sometimes|required|integer',
                'active' => 'sometimes|required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the room by ID
            $room = Room::find($id);

            if (!$room) {
                return response()->json([
                    'message' => 'Room not found'
                ], 404);
            }

            if ($request->has('number')) {
                $room->number = $request->input('number');
            }

            if ($request->has('price')) {
                $room->price = $request->input('price');
            }

            if ($request->has('name')) {
                $room->name = $request->input('name');
            }

            if ($request->has('num_of_people')) {
                $room->num_of_people = $request->input('num_of_people');
            }

            if ($request->has('active')) {
                $room->active = $request->input('active');
            }

            $room->save();

            return response()->json($room, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            // Find the room by ID
            $room = Room::find($id);

            if (!$room) {
                return response()->json([
                    'message' => 'Room not found'
                ], 404);
            }

            // Delete the room
            $room->delete();

            return response()->json([
                'message' => 'Room deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}