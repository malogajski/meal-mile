<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

{{--            <form method="GET" action="{{ route('send-default-email') }}">--}}
{{--                @csrf--}}
{{--                <button type="submit" class="bg-red-600 text-white p-2 rounded hover:bg-red-700 m-2">Send Default Email</button>--}}
{{--            </form>--}}

            @php
                $team = \App\Models\Team::find(auth()->user()->team->id);
            @endphp

            <div class="bg-white text-gray-700 dark:text-gray-300 dark:bg-gray-900 py-4 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:max-w-none">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-500 dark:text-white sm:text-4xl">{{ __("Hello!") }}</h2>
                            <p class="mt-4 text-lg leading-8">{{ auth()->user()->name }}</p>
                        </div>
                        <dl class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4">
                            <div class="flex flex-col bg-gray-200 dark:bg-white/5 p-8">
                                <dt class="text-sm font-semibold leading-6 text-gray-400 dark:text-gray-300">Checklists</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-400 dark:text-white">{{ $totalLists }}</dd>
                                <a href="{{ route('shopping-list') }}" class="text-blue-500 text-sm">Go to checklists</a>
                            </div>
                            <div class="flex flex-col bg-gray-200 dark:bg-white/5 p-8">
                                <dt class="text-sm font-semibold leading-6 text-gray-400 dark:text-gray-300">Total items</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-400 dark:text-white">{{ $totalItems }}</dd>
                                <a href="{{ route('items') }}" class="text-blue-500 text-sm">Go to items</a>
                            </div>
                            <div class="flex flex-col bg-gray-200 dark:bg-white/5 p-8">
                                <dt class="text-sm font-semibold leading-6 text-gray-400 dark:text-gray-300"><span>{{ $team->name }}</span> <span class="font-thin"> members</span></dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-400 dark:text-white">{{ !empty($team->members) ? $team->members->count() : 0 }}</dd>
                            </div>
                            <div class="flex flex-col bg-gray-200 dark:bg-white/5 p-8">
                                <dt class="text-sm font-semibold leading-6 text-gray-400 dark:text-gray-300">{{ $team->owner->name ?? 'n-a' }}</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-400 dark:text-white">Owner</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
