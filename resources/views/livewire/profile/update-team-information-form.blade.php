<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use function Livewire\Volt\state;

state([
    'team'      => fn() => auth()->user()->team,
    'teams'     => fn() => User::with('teams')->find(auth()->user()->id)->teams ?? null,
    'join_to_team_code' => '',
    'user' => Auth::user(),
]);

$requestJoinToTeam = function ($team_code) {

    if (empty($team_code)) {
        return;
    }

//    if ($this->user->hasVerifiedEmail()) {
//        $this->redirectIntended(default: RouteServiceProvider::HOME);
//
//        return;
//    }

    $this->team->members()->syncWithoutDetaching($this->user->id, ['approved' => false, 'owner_id' => $team->owner_id]);
    $this->user->team_id = $team->id;
    $this->user->save();
    $this->user->refresh();
};

$switchTeam = function ($team_id) {
    $this->user->team_id = $team_id;
    $this->user->save();
    $this->user->refresh();
    $this->team->refresh();
}

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Team Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your team information invite or share your team code with other users.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if(!empty($teams))
            <div class="my-6 text-gray-700 dark:text-gray-300">
                <x-input-label for="name" :value="__('Your team')"/>
                <p class="font-semibold">{{ $team->name ?? 'n-a' }}</p>
                <div x-data="{ teamCode: '{{ $team->team_code ?? 'n-a' }}', copied: false }">
                    <div class="flex items-center">
                        <span class="text-sm mr-2">Share your team code:</span>
                        <span class="font-semibold" x-text="teamCode"></span>
                        <button class="ml-2 text-gray-700 dark:text-gray-300"
                                @click="
                                    const textToCopy = teamCode.trim();
                                    navigator.clipboard.writeText(textToCopy).then(() => {
                                        copied = true;
                                        setTimeout(() => { copied = false; }, 2000);
                                    });
                        ">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>

                    <span x-show="copied" class="text-green-500 ml-2">Copied!</span>
                </div>
            </div>
            <div class="my-6">
                <x-input-label for="name" :value="__('You are in teams')"/>
                <ul class="flex items-center space-x-2">
                    @foreach($teams as $team)
                        <li>
                            <button type="button"
                                    wire:click="switchTeam({{$team->id}})"
                                    wire:confirm.prompt="You are going to change working team, are you sure?\n\nType YES to confirm|YES"
                                class="text-xs px-1.5 py-0.5 rounded-full @if(Auth::user()->team_id === $team->id)) bg-lime-700 @else bg-gray-600 @endif text-white">
                                {{ $team->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>

            </div>
        @else
            <p>You don't belong to any team</p>
        @endif
        <div x-data="{ showAddToTeam: false }">
            <span @click="showAddToTeam = !showAddToTeam" class="p-2 mb-4 rounded-md text-sm bg-gray-50 text-gray-800 cursor-pointer hover:bg-gray-200">{{ __('Join to team?') }}</span>
            <div x-show="showAddToTeam" class="my-4">
                <x-text-input type="text" wire:model.live="join_to_team_code" class="rounded-md"/>
                <span wire:click="requestJoinToTeam('{{ $join_to_team_code }}')"  x-on:click="$wire.$refresh()" class="ml-2 p-3 rounded-md bg-green-800 text-white text-xs uppercase cursor-pointer hover:bg-green-600">{{ __('Request join to team') }}</span>
            </div>
        </div>
    </div>

</section>
