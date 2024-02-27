<div x-data="{ showItems: false }">
    <div class="m-6 p-6 bg-white text-gray-700 dark:text-gray-300 rounded-xl shadow-xl dark:bg-gray-800">
        <!-- Back Button at the top -->
        <div class="flex justify-center">
            <x-secondary-button onclick="history.back()">
                <i class="fa fa-arrow-alt-circle-left mr-1"></i> Back
            </x-secondary-button>
        </div>

        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-sm">List of items:</p>
                <p class="font-semibold text-xl">{{ $shoppingList->name ?? 'n-a' }}</p>
            </div>
        </div>
        <div class="w-full flex justify-center my-2 mb-2">
            <x-primary-button @click="showItems = !showItems"
                              x-text="showItems ? 'Hide items' : 'Show items'"
                              class="transition duration-200 ease-in-out transform hover:scale-105"/>
        </div>
        <div class="flex flex-wrap items-start"
             x-show="showItems"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            @foreach($items as $item)
                @php
                    $isInList = \App\Models\ShoppingListItem::where('shopping_list_id', $shopping_list_id)->where('item_id', $item->id)->exists();
                @endphp
                <span class="min-w-20 text-center p-2 rounded transition duration-200 ease-in-out transform hover:-translate-y-1 @if($isInList) bg-gray-400 text-gray-800 @else bg-lime-700 text-white cursor-pointer @endif mx-1 my-1" wire:key="{{ $item->id }}" @if(!$isInList) wire:click="add({{$item->id}})" @else wire:click="remove({{$item->id}})" @endif>{{ $item->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="mt-6 bg-gray-100 dark:bg-gray-800 w-full p-6">
        <livewire:shopping-list-item.index :id="$shopping_list_id"/>
    </div>
</div>
