<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Create a new author along with a user account.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'bio' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create author linked to the user
        $author = Author::create([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Author created successfully',
            'author' => $author->load('user'),
        ], 201);
    }

    /**
     * Get all authors.
     */
    public function index()
    {
        $authors = Author::with('user')->get();
        return response()->json($authors);
    }

    /**
     * Get a specific author.
     */
    public function show($id)
    {
        $author = Author::with('user')->findOrFail($id);
        return response()->json($author);
    }

    /**
     * Get all audiences of an author (through articles).
     */
    public function getAudiences($id)
    {
        $author = Author::findOrFail($id);
        $audiences = $author->audiences()->with('user')->get();
        return response()->json($audiences);
    }
}