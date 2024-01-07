<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIAuthController extends Controller 
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'message' => "Đăng nhập thành công!",
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();   
        return response()->json(['message' => 'Successfully logged out']);
    }

}
