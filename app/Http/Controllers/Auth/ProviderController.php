<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirectSocial($provider, Request $request)
    {
        $request->session()->put('team_code', $request->input('team_code'));

        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial($provider)
    {
        $team_code = session('team_code');
        if (!empty($team_code)) {
            $team_code = decrypt(session('team_code'));
        }

        $user = Socialite::driver($provider)->user();

        $success = $this->signOrRegisterWithProvider($user, $provider, $team_code);

        if ($success) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function signOrRegisterWithProvider($socialUser, $provider, $team_code)
    {
        // Log the socialite user data
        Log::info('[SOCIALITE ACCESS PAYLOAD][' . $provider . ']: ' . json_encode($socialUser));

        try {
            // Find the user by provider ID or email
            $user = User::where($provider . '_id', $socialUser->id)->orWhere('email', $socialUser->email)->first();

            // Find the team based on team_code
            if (!empty($team_code)) {
                $team = Team::where('team_code', $team_code)->first();
            }

            // If team exists and user doesn't have team_id, assign team to user
            if (!empty($team) && empty($user->team_id)) {
                $user->team_id = $team->id;
                $user->save();
            }

            // Create or update the user
            if (empty($user)) {
                $user = User::updateOrCreate([
                    $provider . '_id' => $socialUser->id,
                ], [
                    'name'                       => $socialUser->name,
                    'email'                      => $socialUser->email,
                    $provider . '_token'         => $socialUser->token,
                    $provider . '_refresh_token' => $socialUser->refreshToken ?? null,
                    'team_id'                   => !empty($team) ? $team->id : null,
                ]);
            } else {
                $user->update([
                    $provider . '_id'            => $socialUser->id,
                    $provider . '_token'         => $socialUser->token,
                    $provider . '_refresh_token' => $socialUser->refreshToken ?? null,
                    'team_id'                   => !empty($team) ? $team->id : null,
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
