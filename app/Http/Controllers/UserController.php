<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return response()->json([
            'user' => $user, 'token' => $user->createToken('apiToken')->plainTextToken
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->all();
        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            return response()->json([
                'user' => $user, 'token' => $user->createToken('apiToken')->plainTextToken
            ], 201);
        } else {
            return response()->json(['message' => 'Bad credentials'], 401);
        }
    }

    #[ArrayShape(['message' => "string"])]
    public function logout(Request $request): array
    {
        $request->user()->tokens()->delete();
        return ['message' => 'Logged out'];
    }
}
