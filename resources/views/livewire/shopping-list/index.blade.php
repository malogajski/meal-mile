<div class="m-6 p-6 bg-white rounded-xl shadow-xl dark:bg-gray-800">

    <div class="flex justify-end mb-6">
        <x-primary-button wire:click="newShoppingList">New Shopping List</x-primary-button>
    </div>

    <ul class="flex flex-wrap gap-x-2 gap-y-2">
        @forelse($shoppingLists as $shoppingList)
            <li>
                <x-secondary-button wire:click="goToItems({{$shoppingList->id}})">{{ $shoppingList->name }}</x-secondary-button>
            </li>
        @empty
            <p>No Data</p>
        @endforelse
    </ul>



</div>
