<div class="m-6 p-6 bg-white rounded-xl shadow-xl dark:bg-gray-800">

    <div class="flex justify-end mb-8">
        <x-primary-button class="transition duration-200 ease-in-out transform hover:scale-105 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" wire:click="newShoppingList">New Shopping List</x-primary-button>
    </div>

    <ul class="flex flex-col gap-y-3">
        @forelse($shoppingLists as $shoppingList)
            <li class="">
                <x-secondary-button class="w-full text-center flex justify-center transition duration-200 ease-in-out transform hover:scale-105 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-4 rounded" wire:click="goToItems({{$shoppingList->id}})">{{ $shoppingList->name }}</x-secondary-button>
            </li>
        @empty
            <div class="text-center py-4">
                <p class="text-gray-700 dark:text-gray-400">No Data</p>
            </div>
        @endforelse
    </ul>

</div>
