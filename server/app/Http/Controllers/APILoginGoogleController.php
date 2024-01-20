<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Hash;
class APILoginGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user(); 

        $credentials = request(['email', 'password']);
        $findCustomer = Customer::where('google_id', $user->id)->first();
        if($findCustomer){
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->intended('http://localhost:3000');
        }else{
            $newCustomer = Customer::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'password' => Hash::make('Abc@123')
            ]);
            Auth::login($newCustomer);
            return response()->json([

            ]);
        }

    }
}
