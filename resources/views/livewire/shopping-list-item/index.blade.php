<div>
    <ul class="flex flex-col space-y-2 h-full overflow-y-auto">
        @forelse($shoppingItems as $row)

            <li class="transition duration-200 ease-in-out transform @if($row->is_purchased) dark:bg-green-800 bg-green-200 @else dark:bg-gray-700 dark:text-white text-gray-700 bg-gray-200 @endif p-2 flex items-center justify-between rounded-lg shadow">
                <div class="flex flex-row space-x-4">
                    @if(isset($row->item->media[0]))
                        <img class="rounded-xl shadow w-16 h-16" src="{{$row->item->media[0]['preview_url']}}" alt="img_{{ $row->item->name }}">
                    @endif
                    <div>
                        <p>{{ $row->item->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ !empty($row->item->category) ? $row->item->category->name : '' }}
                            {{ !empty($row->item->subCategory) ? ' | ' . $row->item->subCategory->name : '' }}
                        </p>
                    </div>
                </div>

                @if($row->is_purchased)
                    <div class="flex space-x-6">
                        <button type="button"
                                wire:confirm="Are you sure you didn't buy this?"
                                wire:click="cancel({{ $row->item->id }})" class="text-orange-600 p-2">
                            <i class="fa-solid fa-rotate-left"></i>
                        </button>
                        <i class="fas fa-check text-green-600 p-2"></i>
                    </div>
                @else
                    <div class="flex space-x-6">
                        <button type="button" class="text-blue-600 p-2" wire:click="purchased({{$row->item->id}})">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                        <button type="button" class="text-red-600 px-2"
                                wire:confirm="Are you sure you want to delete from the list?"
                                wire:click="remove({{$row->item->id}})">
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
