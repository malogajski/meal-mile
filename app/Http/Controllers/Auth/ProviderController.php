<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirectSocial($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial($provider)
    {
        $user = Socialite::driver($provider)->user();

        $success = $this->signOrRegisterWithProvider($user, $provider);

        if ($success) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function signOrRegisterWithProvider($socialUser, $provider)
    {
        try {
            $user = User::where($provider . '_id', $socialUser->id)->orWhere('email', $socialUser->email)->first();

            if (empty($user)) {
                $user = User::updateOrCreate([
                    $provider . '_id' => $socialUser->id,
                ], [
                    'name'                 => $socialUser->name,
                    'email'                => $socialUser->email,
                    $provider . '_token'         => $socialUser->token,
                    $provider . '_refresh_token' => $socialUser->refreshToken ?? null,
                ]);
            } else {
                $user->update([
                    $provider . '_id'            => $socialUser->id,
                    $provider . '_token'         => $socialUser->token,
                    $provider . '_refresh_token' => $socialUser->refreshToken ?? null,
                ]);
            }

            Auth::login($user);

            if (Auth::check()) {
                return true;
            }
        } catch (\Throwable $e) {
            Log::error('[SOCIAL LOGIN OR REGISTER ERROR]: ' . $e->getMessage());
        }

        return false;
    }
}
