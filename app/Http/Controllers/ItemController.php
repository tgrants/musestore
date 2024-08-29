<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file',
            'type_id' => 'required|exists:types,id',
            'piece_id' => 'required|exists:pieces,id',
        ]);

        $originalFileName = $request->file('file')->getClientOriginalName();
        // $filePath = $request->file('file')->storeAs('uploads', $originalFileName);
        $filePath = $request->file('file')->store('uploads', 'public');

        $item = new Item();
        $item->name = $validated['name'];
        $item->filepath = $filePath;
        $item->type_id  = $validated['type_id'];
        $item->piece_id = $validated['piece_id'];
        $item->save();

        //return redirect()->route('pieces.show', $item->piece_id)->with('success', 'Item added successfully.');
        return response()->json(['success' => 'Item added successfully.']);
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
        $item = Item::findOrFail($id);

        Storage::disk('public')->delete($item->filepath);

        $item->delete();

        return response()->json(['success' => 'Item deleted successfully.']);
    }
}
