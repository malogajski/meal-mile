<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meal Mile - Efficient Shopping & Travel Planning</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    @if (Route::has('login'))
        <div class="fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <img src="{{ asset('base/logo-150.svg') }}" alt="">
        </div>

        <div class="mt-16 dark:text-gray-300">
            <h1 class="text-center text-3xl font-semibold">Welcome to Meal Mile</h1>
            <p class="text-center mt-4">Your ultimate tool for efficient shopping and travel planning. Manage your shopping lists and travel checklists in one place, and get suggestions for recipes based on your pantry items!</p>

            <!-- Additional sections for About, Features etc. if needed -->
        </div>
    </div>
</div>
</body>
</html>
