<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Retrieve all guests from the database
        $guests = Guest::all();

        // Return the guests as a JSON response
        return response()->json($guests);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'age' => 'required|integer|min:0',
                'phone' => 'required|string|max:15',
                'gender' => 'required|string|in:male,female,other',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create a new guest
            $guest = new Guest();
            $guest->name = $request->input('name');
            $guest->age = $request->input('age');
            $guest->phone = $request->input('phone');
            $guest->gender = $request->input('gender');
            $guest->save();

            $room = Room::find($request->input('room_id'));
            $room->active = false;
            $room->save();

            return response()->json($guest, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
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
                'name' => 'sometimes|required|string|max:255',
                'age' => 'sometimes|required|integer|min:0',
                'phone' => 'sometimes|required|string|max:15',
                'gender' => 'sometimes|required|string|in:male,female,other',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the guest by ID
            $guest = Guest::find($id);

            if (!$guest) {
                return response()->json([
                    'message' => 'Guest not found'
                ], 404);
            }

            // Update fields if they are present in the request
            if ($request->has('name')) {
                $guest->name = $request->input('name');
            }

            if ($request->has('age')) {
                $guest->age = $request->input('age');
            }

            if ($request->has('phone')) {
                $guest->phone = $request->input('phone');
            }

            if ($request->has('gender')) {
                $guest->gender = $request->input('gender');
            }

            // Save the updated guest
            $guest->save();

            return response()->json($guest, 200);
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
            // Find the guest by ID
            $guest = Guest::find($id);

            if (!$guest) {
                return response()->json([
                    'message' => 'Guest not found'
                ], 404);
            }

            // Delete the guest
            $guest->delete();

            return response()->json([
                'message' => 'Guest deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}