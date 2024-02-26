<div>
    <p>List of items from shopping list no: {{ $shoppingListId }}</p>
    <ul class="flex flex-col space-y-2">
        @forelse($shoppingItems as $row)

            <li class="@if($row->is_purchased) bg-green-800 @else dark:bg-gray-700 dark:text-white text-gray-700 bg-gray-200 @endif p-2 flex items-center justify-between">
                <span>{{ $row->item->name }}</span>

                @if($row->is_purchased)
                    <i class="fas fa-check text-green-600"></i>
                @else
                    <div class="flex space-x-6">
                        <button type="button" class="text-blue-600" wire:click="purchased({{$row->item->id}})">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                        <button type="button" class="text-red-600" wire:click="remove({{$row->item->id}})">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                @endif

            </li>
        @empty
            <p>No items added</p>
        @endforelse
    </ul>
</div>
