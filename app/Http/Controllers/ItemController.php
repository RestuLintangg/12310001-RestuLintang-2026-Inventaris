<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $items = Item::with('lendingDetails.lending')->get();
        $categories = Category::all();

        return view('items.index', compact('items', 'categories'));
    }

    public function staffIndex() 
    {
        $items = Item::all();
        $categories = Category::all();

        return view('items.index_staff', compact('items', 'categories'));
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
        //
        $request->validate([
            'name' => 'required',
            'total' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        Item::create($request->all());

        return back()->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $item = Item::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'total' => 'required|integer',
            'new_broke_item' => 'nullable|integer|min:0',
        ]);

        $oldRepair = $item->repair;
        $newRepair = $oldRepair + ($request->new_broke_item ?? 0);

        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => $newRepair,
        ]);

        return back()->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
