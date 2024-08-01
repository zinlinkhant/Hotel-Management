<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Http\Requests\StoreReviewsRequest;
use App\Http\Requests\UpdateReviewsRequest;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Reviews::with('room', 'guest')->get();
        return response()->json($reviews);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'rating' => 'required|integer|min:1|max:10',
            'text' => 'nullable|string',
        ]);

        $review = Reviews::create($request->all());
        return response()->json($review, 201);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $review = Reviews::findOrFail($id);

        $request->validate([
            'room_id' => 'sometimes|exists:rooms,id',
            'guest_id' => 'sometimes|exists:guests,id',
            'rating' => 'sometimes|integer|min:1|max:10',
            'text' => 'nullable|string',
        ]);

        $review->update($request->all());
        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = Reviews::findOrFail($id);
        $review->delete();
        return response()->json(['message' => 'Review deleted successfully.']);
    }
}
