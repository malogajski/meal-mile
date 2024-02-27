<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome message -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center">
                    {{ __("Hello!") }}
                    {{ auth()->user()->name }}
                </div>
            </div>
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total number of lists -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <!-- List icon -->
                    <svg class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Number of Lists</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $totalLists }}</p>
                    </div>
                </div>
                <!-- Total number of items -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <!-- Item icon -->
                    <svg class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Number of Items</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $totalItems }}</p>
                    </div>
                </div>
                <!-- Most frequently purchased item -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <!-- Shopping cart icon -->
                    <svg class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.344 2m2.656 0H20l-2 9H7L5 5H2" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Most Frequently Purchased Item</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $mostFrequentItemName }} ({{ $mostFrequentItem->count }} times)</p>
                    </div>
                </div>
                <!-- Average number of items per list -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <!-- Stats icon -->
                    <svg class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V3h2v8h-2zm-4 4V3h2v12h-2zm8 0v-4h2v4h-2zm4 4v-8h2v8h-2zM7 21v-4h2v4H7z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Average Number of Items per List</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ number_format($avgItemsPerList, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
