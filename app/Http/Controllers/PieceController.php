<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\Tag;
use App\Models\Category;
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
        return view('pieces.show', compact('piece'));
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
        //
    }
}
