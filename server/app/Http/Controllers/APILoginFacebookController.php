<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Hash;
class APILoginFacebookController extends Controller
{
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback(){
        try{
            $user = Socialite::driver('facebook')->user();
            $findUser = Customer::where('facebook_id', $user->id)->first();

            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('/');
            }else{
                $newUser = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => Hash::make('Abc@123')
                ]);
                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
