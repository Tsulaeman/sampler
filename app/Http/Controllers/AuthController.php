<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate(
            [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|unique:users',
                    'password' => [
                        'min:8',
                        'regex:/^(?=.*[0-9])(?=.*[A-Z])([a-zA-Z0-9]+)$/',
                        'max:255'
                    ],
                    'date_of_birth' => 'required|date_format:Y-m-d'
                ],
            [
                    'password.regex' => 'Password must contain atleast 1 number and 1 uppercase letter'
                ]
        );

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $token = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($loginData)) {
            return response([
                'message' => 'Invalid email or password.',
            ]);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response([
            'user' => Auth::user(),
            'token' => $token
        ]);
    }
}
