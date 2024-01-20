<?php

namespace App\Http\Controllers;

use App\Http\Requests\APILoginRequest;
use App\Models\Customer;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;
use Hash;

class APIAuthController extends Controller
{
    public function login(APILoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'message' => "Đăng nhập thành công!",
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 120
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

    public function redirectToGoogle(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    public function handleGoogleCallback()
    {
        try {
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $user = Customer::query()->firstOrCreate(
            [
                'email' => $socialiteUser->getEmail(),
            ],
            [
                'name' => $socialiteUser->getName(),
                'google_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar(),
                'password' => Hash::make('Abc@123'),
                'status' => 1,
            ]
        );
        
        $token = auth('api')->login($user);

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

}
