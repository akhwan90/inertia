<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    //
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Handle callback dari provider
    public function callback($provider): RedirectResponse
    {
        $socialUser = Socialite::driver($provider)->user();

        // Cari user berdasarkan email, jika tidak ada buat user baru
        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'provider_id' => $socialUser->getId(),
                'provider' => $provider,
                'password' => bcrypt(str()->random(12)), // Dummy password
                'level'=>'user',
            ]
        );

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
