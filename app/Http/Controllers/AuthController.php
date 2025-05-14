<?php

namespace App\Http\Controllers;

use App\Jobs\SendDigestEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserRegistrationService;

class AuthController extends Controller
{
    protected UserRegistrationService $registrationService;

    public function __construct(UserRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);


        $user = $this->registrationService->register($request->only([
            'name', 'email', 'password'
        ]));

        return response()->json([
            'token' => $user->createToken('main')->plainTextToken,
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

       
        return response()->json([
            'token' => $user->createToken('main')->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
