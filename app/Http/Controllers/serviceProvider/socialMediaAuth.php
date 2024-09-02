<?php

namespace App\Http\Controllers\serviceProvider;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;


class socialMediaAuth extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {
        try {
            $user = Socialite::driver('google')->user();
            $find_user = User::where('email', $user->email)->first();

            if (!$find_user) {
                // User doesn't exist, create a new user
                $name_parts = explode(' ', $user->name);

                $newUser = User::create([
                    'first_name' => $name_parts[0],
                    'last_name' => isset ($name_parts[1]) ? $name_parts[1] : '',
                    'middle_name' =>  '',
                    'email' => $user->email,
                    'profile_image' => $user->avatar,
                    'login_type' => 'G',
                    'role' => 'S',
                    'social_id' => $user->token,
                    'is_varified'=>1,
                    'is_online'=>1,
                ]);

                // Log in the newly created user
                Auth::login($newUser);
                return redirect()->route('service-provider-dashboard')->with('success', 'Logged in successfully.');

            } else {
                // User already exists, verify the token
                // if ($user->token === $find_user->social_id) {
                //     Auth::login($find_user);
                //     return redirect()->route('service-provider-dashboard')->with('success', 'Logged in successfully.');

                // } else {
                //     // Token mismatch, handle accordingly
                //     return redirect()->back()->with('error', 'Token mismatch. Please try again.');
                // }
                Auth::login($find_user);
                return redirect()->route('service-provider-dashboard')->with('success', 'Logged in successfully.');

            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
