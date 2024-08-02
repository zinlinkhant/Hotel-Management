<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Guest;
use App\Models\HotelBook;
use App\Models\Invetory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
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
        $request->validate([
            'invetory_id' => 'required|exists:invetories,id',
            'hotelbook_id' => 'required|exists:hotel_books,id',
            'quantity' => 'required|integer',
        ]);

        try {
            $item = Invetory::findOrFail($request->invetory_id);
            $price = $item->price * $request->quantity;

            $order = new Order();
            $order->fill([
                'invetory_id' => $request->invetory_id,
                'hotelbook_id' => $request->hotelbook_id,
                'quantity' => $request->quantity,
                'price' => $price,
            ]);

            $hotel = HotelBook::findOrFail($request->hotelbook_id);
            $addPrice = $hotel->price + $price;
            $hotel->price = $addPrice;

            $guest = Guest::findOrFail($hotel->guest_id);
            $addPoint = ceil($price / 100);
            $guest->points = $guest->points + $addPoint;

            $hotel->save();
            $guest->save();
            $order->save();


            return response()->json($order, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Inventory item not found'], 404);
        } catch (\Exception $e) {
            Log::error('Order creation failed', ['exception' => $e]);
            return response()->json(['error' => 'An error occurred while creating the order'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'inventory_id' => 'required|exists:invetories,id',
            'hotelbook_id' => 'required|exists:hotelbooks,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $order->update([
            'inventory_id' => $request->inventory_id,
            'hotelbook_id' => $request->hotelbook_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
