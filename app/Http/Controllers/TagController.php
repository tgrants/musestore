<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::with('category')->get();
        $categories = Category::all();
        return view('tags.index', compact('tags', 'categories'));
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
            'category_id' => 'required|exists:categories,id',
        ]);

        $tag = Tag::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
        ]);

        return response()->json(['message' => 'Tag added successfully.', 'tag' => $tag], 201);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json(['error' => 'Tag not found.'], 404);
        }

        $tag->name = $validated['name'];
        $tag->category_id = $validated['category_id'];
        $tag->save();

        return response()->json(['success' => 'Tag updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json(['error' => 'Tag not found.'], 404);
        }

        $tag->delete();
        return response()->json(['success' => 'Tag deleted successfully.']);
    }
}
