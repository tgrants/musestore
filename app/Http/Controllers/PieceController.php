<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Piece;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tags = Tag::all();
        $categories = Category::all();

        if ($request->has('tags') && !empty($request->tags)) {
            $pieces = Piece::whereHas('tags', function($query) use ($request) {
                $query->whereIn('tags.id', $request->tags);
            })->get();
        } else {
            $pieces = Piece::all();
        }

        return view('pieces.index', compact('pieces', 'tags', 'categories'));
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
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $piece = Piece::create(['name' => $validated['name']]);
        if (isset($validated['tags'])) {
            $piece->tags()->attach($validated['tags']);
        }

        return redirect()->route('pieces.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $piece = Piece::with(['items', 'tags'])->findOrFail($id);
        $types = Type::orderBy('name')->get();

        return view('pieces.show', compact('piece', 'types'));
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
    public function destroy($id)
    {
        // Retrieve the piece by its id
        $piece = Piece::findOrFail($id);

        // Delete associated items and their files
        foreach ($piece->items as $item) {
            // Delete the file from storage
            Storage::disk('public')->delete($item->filepath);
            // Delete the item record
            $item->delete();
        }

        // Delete the piece itself
        $piece->delete();

        return redirect()->route('pieces.index')->with('success', 'Piece deleted successfully.');
    }
}
