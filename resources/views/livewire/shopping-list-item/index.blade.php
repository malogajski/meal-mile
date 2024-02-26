<div>

    <ul class="flex flex-col space-y-2">
        @forelse($shoppingItems as $row)

            <li class="@if($row->is_purchased) dark:bg-green-800 bg-green-200 @else dark:bg-gray-700 dark:text-white text-gray-700 bg-gray-200 @endif p-2 flex items-center justify-between">
                <span>{{ $row->item->name }}</span>

                @if($row->is_purchased)
                    <div class="flex space-x-6">
                        <button type="button" wire:click="cancel({{ $row->item->id }})" class="text-orange-600 p-2">
                            <i class="fa-solid fa-rotate-left"></i>
                        </button>
                        <i class="fas fa-check text-green-600 p-2"></i>
                    </div>
                @else
                    <div class="flex space-x-6">
                        <button type="button" class="text-blue-600 p-2" wire:click="purchased({{$row->item->id}})">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                        <button type="button" class="text-red-600 px-2" wire:click="remove({{$row->item->id}})">
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
