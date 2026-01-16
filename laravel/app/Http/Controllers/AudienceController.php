docker-compose up --build -d<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AudienceController extends Controller
{
    /**
     * Create a new audience along with a user account.
     */
    public function store(Request $request)
    {
        // Add authorization check (e.g., only admins can create)
        $this->authorize('create', Audience::class);  // Assumes AudiencePolicy exists

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'description' => 'nullable|string',
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

        // Create audience linked to the user
        $audience = Audience::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Audience created successfully',
            'audience' => $audience->load('user'),
        ], 201);
    }

    /**
     * Get all audiences.
     */
    public function index()
    {
        $audiences = Audience::with('user')->get();
        return response()->json($audiences);
    }

    /**
     * Get a specific audience.
     */
    public function show($id)
    {
        $audience = Audience::with('user')->findOrFail($id);
        return response()->json($audience);
    }
}