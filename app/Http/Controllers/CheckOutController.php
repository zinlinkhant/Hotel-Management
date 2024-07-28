<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Http\Requests\StoreCheckOutRequest;
use App\Http\Requests\UpdateCheckOutRequest;
use App\Models\HotelBook;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkOuts = CheckOut::all();
        $checkOuts->load(['hotelBook.guest', 'hotelBook.room']);
        return response()->json($checkOuts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'hotelbook_id' => 'required|exists:hotel_books,id', // Ensure it exists in the hotel_books table
            ]);

            $hotelbook = HotelBook::findOrFail($request->input('hotelbook_id'));
            $checkOut = new CheckOut();
            $checkOut->hotelbook_id = $request->input('hotelbook_id');
            $checkOut->price = $hotelbook->price;
            $checkOut->guest_id = $hotelbook->guest_id;
            $checkOut->room_id = $hotelbook->room_id;
            $hotelbook->payed = true;
            $hotelbook->save();

            $checkOut->save();
            $checkOut->load(['hotelBook.guest', 'hotelBook.room']);
            return response()->json($checkOut, 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Hotel booking not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors()
            ], 400);
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
    public function create(StoreCheckOutRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CheckOut $checkOut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CheckOut $checkOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'hotelbook_id' => 'required|exists:hotel_books,id',
            'checkout_date' => 'required|date',
        ]);

        $checkOut = CheckOut::findOrFail($id);
        $checkOut->hotelbook_id = $request->input('hotelbook_id');
        $checkOut->checkout_date = $request->input('checkout_date');

        $checkOut->save();

        return response()->json($checkOut);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $checkOut = CheckOut::findOrFail($id);
        $checkOut->delete();

        return response()->json(['message' => 'CheckOut deleted successfully']);
    }
}