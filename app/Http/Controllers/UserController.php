<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
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
            'password' => 'nullable|string',
            'enabled' => 'required|boolean',
            'admin' => 'required|boolean',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->name = $validated['name'];
        $user->enabled = $validated['enabled'];
        $user->admin = $validated['admin'];
        $user->save();

        return response()->json(['success' => 'User updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $user->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}
