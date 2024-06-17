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
            $team = null;
            // Find the user by provider ID or email
            $user = User::where($provider . '_id', $socialUser->id)->orWhere('email', $socialUser->email)->first();
            $teamId = $user->team_id ?? null; // Preserve the current team_id if it exists

            // Find the team based on team_code
            if (!empty($team_code)) {
                $team = Team::where('team_code', $team_code)->first();
                $teamId = $team->id ?? $teamId; // Update teamId if a team is found for the team_code
            }

            // Prepare user data to be updated or created
            $userData = [
                'name'                       => $socialUser->name,
                'email'                      => $socialUser->email,
                $provider . '_token'         => $socialUser->token,
                $provider . '_refresh_token' => $socialUser->refreshToken ?? null,
            ];

            // Set team_id if team exists and user doesn't have a team_id already
            if (!is_null($team) && empty($user->team_id)) {
                $userData['team_id'] = $teamId;
            }

            // Create or update the user
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Create a new team for the new user
            if (empty($team)) {
                $team = Team::create([
                    'name' => $user->name . "'s Team",
                ]);
                $team->members()->attach($user->id, ['approved' => true, 'owner_id' => $user->id]);
            }

            // Log in the user
            Auth::login($user);

            if ($user->wasRecentlyCreated) {
                Auth::user()->sendEmailVerificationNotification();
            }

            if (Auth::check()) {
                return true;
            }
        } catch (\Throwable $e) {
            Log::error('[SOCIAL LOGIN OR REGISTER ERROR]: ' . $e->getMessage());
        }

        return false;
    }

}
