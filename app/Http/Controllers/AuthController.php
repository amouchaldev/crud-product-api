<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string', 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
        $token = $user->createToken('API TOKEN')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'User Has Been Created Successfully',
            'token' => $token
        ], 201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::whereEmail($request['email'])->first();
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json([
                'status' => false, 
                'message' => 'Email Or Password Not Correct',
            ]);
        }
        return response()->json([
            'status' => true, 
            'message' => 'Logged In Successfully',
            'user' => New UserResource($user), 
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ]);
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200, 
            'message' => 'Logged out Successfully'
        ]);
    }
}
