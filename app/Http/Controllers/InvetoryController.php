<?php

namespace App\Http\Controllers;

use App\Models\Invetory;
use App\Http\Requests\StoreInvetoryRequest;
use App\Http\Requests\UpdateInvetoryRequest;
use Illuminate\Http\Request;

class InvetoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $inventories = Invetory::all();
            return response()->json($inventories);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching inventory items.',
                'error' => $e->getMessage()
            ], 500);
        }
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
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0'
            ]);

            $inventory = Invetory::create([
                'name' => $request->input('name'),
                'price' => $request->input('price')
            ]);

            return response()->json($inventory, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the inventory item.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invetory $invetory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invetory $invetory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'price' => 'sometimes|numeric|min:0'
            ]);

            $inventory = Invetory::findOrFail($id);

            if ($request->has('name')) {
                $inventory->name = $request->input('name');
            }

            if ($request->has('price')) {
                $inventory->price = $request->input('price');
            }

            $inventory->save();

            return response()->json($inventory);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the inventory item.',
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
            $inventory = Invetory::findOrFail($id);
            $inventory->delete();

            return response()->json(['message' => 'Inventory item deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the inventory item.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
