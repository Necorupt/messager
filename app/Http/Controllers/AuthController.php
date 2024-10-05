<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'email or password is invalid'], 422);
        }

        $user = Auth::user();

        $accessToken = $user->createToken('access_token')->plainTextToken;


        return response()->json([
            'success' => true,
            'tokens' => ['access_token' => $accessToken]
        ]);
    }

    public function register(Request $request): JsonResponse 
    {
        $request->validate([
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:users',
            'password' => 'required|string|min',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $accessToken = $user->createToken('access_token')->plainTextToken;

        return response()->json([
           'success' => true,
            'tokens' => ['access_token' => $accessToken]
        ], 201);
    }
}
