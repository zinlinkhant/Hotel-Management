<?php

namespace App\Http\Controllers;

use App\Models\HotelBook;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        try {

            $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'guest_id' => 'required|exists:guests,id',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);




            $hotelBook = new HotelBook();
            $hotelBook->room_id = $request->input('room_id');
            $room = Room::find($hotelBook->room_id);
            $hotelBook->guest_id = $request->input('guest_id');
            $hotelBook->check_in_date = $request->input('check_in_date');
            $hotelBook->check_out_date = $request->input('check_out_date');

            $checkIn = Carbon::parse($hotelBook->check_in_date);
            $checkOut = Carbon::parse($hotelBook->check_out_date);
            $daysDifference = $checkIn->diffInDays($checkOut);

            $hotelBook->num_of_people = $room->num_of_people;
            $hotelBook->price = $daysDifference * $room->price;

            $booking = HotelBook::where('guest_id', $hotelBook->guest_id)
                ->where('room_id', $hotelBook->room_id)
                ->where('check_in_date', $hotelBook->check_in_date)
                ->first();

            if ($booking) {
                return "hotel book already exist";
            }

            $hotelBook->save();

            return response()->json($hotelBook);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
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
                'room_id' => 'sometimes|required|exists:rooms,id',
                'guest_id' => 'sometimes|required|exists:guests,id',
                'check_in_date' => 'sometimes|required|date',
                'check_out_date' => 'sometimes|required|date|after:check_in_date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the booking by ID
            $hotelBook = HotelBook::find($id);

            if (!$hotelBook) {
                return response()->json([
                    'message' => 'Booking not found'
                ], 404);
            }

            // Update fields if they are present in the request
            if ($request->has('room_id')) {
                $hotelBook->room_id = $request->input('room_id');
            }

            if ($request->has('guest_id')) {
                $hotelBook->guest_id = $request->input('guest_id');
            }

            if ($request->has('check_in_date')) {
                $hotelBook->check_in_date = $request->input('check_in_date');
            }

            if ($request->has('check_out_date')) {
                $hotelBook->check_out_date = $request->input('check_out_date');
            }

            // Recalculate the number of days and price if dates or room are updated
            if ($request->has('check_in_date') || $request->has('check_out_date') || $request->has('room_id')) {
                $checkIn = Carbon::parse($hotelBook->check_in_date);
                $checkOut = Carbon::parse($hotelBook->check_out_date);
                $daysDifference = $checkIn->diffInDays($checkOut);

                if ($request->has('room_id')) {
                    $room = Room::find($hotelBook->room_id);
                } else {
                    $room = Room::find($hotelBook->room_id);
                }

                $hotelBook->num_of_people = $room->num_of_people;
                $hotelBook->price = $daysDifference * $room->price;
            }

            // Save the updated booking
            $hotelBook->save();

            return response()->json($hotelBook, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the booking by ID
            $hotelBook = HotelBook::find($id);

            if (!$hotelBook) {
                return response()->json([
                    'message' => 'Booking not found'
                ], 404);
            }

            // Delete the booking
            $hotelBook->delete();

            return response()->json([
                'message' => 'Booking deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
