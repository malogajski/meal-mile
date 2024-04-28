<div class="m-2 p-2 bg-white rounded-xl shadow-xl dark:bg-gray-800">
    <x-loading-spinner wire:loading/>

    <div class="flex justify-end mb-8 mt-2">
        <x-primary-button class="transition duration-200 ease-in-out transform hover:scale-105 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" wire:click="newShoppingList">
            <i class="fa fa-plus mr-1"></i>
            New Shopping List
        </x-primary-button>
    </div>

    <ul class="flex flex-col gap-y-3">
        @forelse($shoppingLists as $shoppingList)
            <li class="flex">
                <div class="flex items-center space-x-2 w-full">
                    <span class="w-full text-center flex flex-col items-center justify-center transition duration-200 ease-in-out transform bg-gray-100 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-300 py-3 px-4 rounded" wire:click="goToItems({{$shoppingList->id}})">
                    <p class="font-semibold">{{ $shoppingList->name }}</p>
                    <span class="text-blue-500 ml-2 text-xs">(items: {{ $shoppingList->items ? $shoppingList->items->count() : 0 }})</span>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Created by: {{ $shoppingList->user->name ?? '' }}</p>
                        <div>
                            @if($shoppingList->type === \App\Enums\ListTypeEnum::ShoppingList)
                            <span class="badge-purple">{{ \App\Enums\ListTypeEnum::getKey($shoppingList->type) ?? '' }}</span>
                            @else
                                <span class="badge-green">{{ \App\Enums\ListTypeEnum::getKey($shoppingList->type) ?? '' }}</span>
                            @endif
                        </div>
                </span>
                    <x-secondary-button class="flex justify-center w-16 h-full" wire:click="edit({{$shoppingList->id}})"><i class="fa fa-edit"></i></x-secondary-button>
                    <x-danger-button class="flex justify-center w-16 h-full" wire:click="delete({{$shoppingList->id}})"><i class="fa fa-trash-alt"></i></x-danger-button>
                </div>
            </li>
        @empty
            <div class="text-center py-4">
                <p class="text-gray-700 dark:text-gray-400">No Data</p>
            </div>
        @endforelse
    </ul>

</div>
