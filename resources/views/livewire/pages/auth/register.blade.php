<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name'                  => '',
    'email'                 => '',
    'password'              => '',
    'password_confirmation' => '',
    'team_code'             => null,
]);

rules([
    'name'      => ['required', 'string', 'max:255'],
    'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password'  => ['required', 'string', 'confirmed', Rules\Password::defaults()],
    'team_code' => ['nullable', 'exists:teams,team_code'],
]);

$register = function () {

    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    $user = User::create($validated);

    if (!empty($validated['team_code'])) {
        $team = \App\Models\Team::where('team_code', $validated['team_code'])->firstOrFail();
        $team->members()->attach($user->id, ['approved' => false, 'owner_id' => $team->owner_id]);
    } else {
        // Create a new team for the user
        $team = \App\Models\Team::create([
            'name' => $user->name . "'s Team",
        ]);
        $team->members()->attach($user->id, ['approved' => true, 'owner_id' => $user->id]);
    }

    $user->team_id = $team->id;
    $user->default_team_id = $team->id;
    $user->save();
    $user->refresh();

    event(new Registered($user));

    Auth::login($user);

    $this->redirect(RouteServiceProvider::HOME, navigate: true);
};

?>

<div x-data="{ showTeam: false, showForm: false, showOptions: true, teamCode: '' }">
    {{-- Options --}}
    <div class="flex flex-col w-full" x-show="showOptions">
        <div class="flex justify-between mb-4 space-x-2">
            <button class="btn-lg btn-default" @click="showTeam = true; showOptions = false">Join the team <i class="fa-solid fa-people-group ml-1"></i></button>
            <button class="btn-lg btn-purple" @click="showForm = true; showOptions = false">New registration <i class="fa-solid fa-user-plus ml-1"></i></button>
        </div>

        <a class="text-sm hover:underline text-center" href="{{ route('login') }}">Back to login</a>
    </div>

    <div class="flex justify-end my-2" x-show="!showOptions" x-cloak>
        <span class="btn btn-alternative" @click="showForm ? showTeam=true : (showOptions = true, showTeam=false, teamCode = ''); showForm = false; ">
            <i class="fa-solid fa-circle-left mr-1"></i>Back
        </span>
    </div>

    {{-- Team code --}}
    <div x-show="showTeam" class="flex flex-col w-full">
        <input type="text" x-model="teamCode" placeholder="Enter Team Code" x-bind:maxlength="16" x-on:input="teamCode.length >= 4 ? $refs.continueButton.removeAttribute('disabled') : $refs.continueButton.setAttribute('disabled', true)">
        <button x-ref="continueButton" class="btn btn-green mt-2" @click="showForm = true; showTeam = false; $wire.set('team_code', teamCode)" :disabled="teamCode.length < 4 || teamCode.length > 16">Continue</button>
    </div>

    <form x-show="showForm" x-cloak wire:submit="register">

        <p>TEAM: {{ $team_code ?? '' }}</p>
        <div>
            @error('team_code')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
               href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Continue with social --}}
    <div x-show="showForm" x-cloak>
        <div class="relative mt-10">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm font-medium leading-6">
                <span class="bg-white px-6 text-gray-900">Or continue with</span>
            </div>
        </div>
        <div class="mt-6 flex w-full items-center justify-between">
            @php
                $args = '';
                if(!empty($team_code)) {
                    $encrypted = encrypt($team_code);
                    $args = "?team_code=$encrypted";
                }
            @endphp
                <!-- Google -->
            <a href="/auth/google/redirect{{$args}}" data-twe-ripple-init data-twe-ripple-color="light"
               class="mb-2 inline-block rounded bg-[#ea4335] px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:bg-white hover:text-[#ea4335] hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
            <span class="[&>svg]:h-4 [&>svg]:w-4">
              @include('svg.google-icon')
            </span>
            </a>

            <!-- Facebook -->
            <a href="/auth/facebook/redirect{{$args}}" data-twe-ripple-init data-twe-ripple-color="light"
               class="mb-2 inline-block rounded bg-[#1877f2] px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:bg-white hover:text-[#1877f2] hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
            <span class="[&>svg]:h-4 [&>svg]:w-4">
              @include('svg.facebook-icon')
            </span>
            </a>

            <!-- Github -->
            <a href="/auth/github/redirect{{$args}}" data-twe-ripple-init data-twe-ripple-color="light"
               class="mb-2 inline-block rounded bg-[#333] hover:bg-white px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white hover:text-black shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
            <span class="[&>svg]:h-4 [&>svg]:w-4">
                @include('svg.github-icon')
            </span>
            </a>

            <!-- X -->
            <a href="/auth/twitter/redirect{{$args}}" data-twe-ripple-init data-twe-ripple-color="light"
               class="mb-2 inline-block rounded bg-black px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg hover:bg-white hover:text-black focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
            <span class="[&>svg]:h-4 [&>svg]:w-4">
              @include('svg.twitter-icon')
            </span>
            </a>

        </div>
    </div>

</div>
