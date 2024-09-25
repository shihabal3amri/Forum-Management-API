<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\UserProfile; // Import the UserProfile class

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create the user profile with bio
        $profile = UserProfile::create([
            'user_id' => $user->id,
            'bio' => $request->bio ?? null, // Bio can be null
        ]);

        // Load the user's profile into the user object
        $user->load('profile'); // This will eager load the 'profile' relationship

        // Generate the authentication token
        $token = $user->createToken('authToken')->accessToken;

        // Return the token and user with profile
        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    // Login user
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = Auth::user();
        $user->load('profile'); // Load the profile relationship

        $token = $user->createToken('authToken')->accessToken;

        // Return the token and user with profile
        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    // Logout user
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
