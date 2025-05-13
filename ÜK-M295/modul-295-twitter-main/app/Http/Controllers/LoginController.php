<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $request->user(); // oder: Auth::user()
            $token = $user->createToken('auth_token')->plainTextToken; // PlainTextToken ist ein Property, das die Token-String zurückgibt

            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json([
            'errors' => [
                'general' => 'E-Mail oder Passwort falsch.'
            ]
        ], 422);
    }
}
