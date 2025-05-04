<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController
{
    public function register(Request $request)
    {
        if (auth()->check()) {
            return redirect()->to('/');
        }

        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'in:Client,Manager,Admin'
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        
        $token = JWTAuth::fromUser($user);
        
        session(['token' => $token]);

        return redirect()->to('/');
    }

    public function login(Request $request)
    {
        if (auth()->check()) {
            return redirect()->to('/');
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        session(['token' => $token]);
        return redirect()->to('/');
    }

    public function logout()
    {
        auth()->logout();
        session()->forget('token');
        return redirect()->route('login');
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}

