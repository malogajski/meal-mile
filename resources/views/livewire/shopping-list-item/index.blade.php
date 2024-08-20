<div>
    <ul class="flex flex-col space-y-2 h-full overflow-y-auto">
        @forelse($shoppingItems as $row)
            <li key="{{ $row->id }}" class="transition duration-200 ease-in-out transform {{ $row->is_purchased ? 'dark:bg-gray-600 bg-green-200 dark:text-gray-300' : 'dark:bg-gray-700 dark:text-white text-gray-700 bg-gray-200' }} p-2 flex items-center justify-between rounded-lg shadow">
                <div class="flex flex-row space-x-4">
                    @if(isset($row->item->media[0]))
                        <img class="rounded-xl shadow w-16 h-16" src="{{$row->item->media[0]['preview_url']}}" alt="img_{{ $row->item->name }}">
                    @else
                        <img class="rounded-xl shadow w-16 h-16" src="{{ asset('assets/no-image.jpg') }}" alt="img_{{ $row->item->name }}">
                    @endif
                    <div>
                        <p>{{ $row->item->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ !empty($row->item->category) ? $row->item->category->name : '' }}
                            {{ !empty($row->item->subCategory) ? ' | ' . $row->item->subCategory->name : '' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer"
                               wire:change="togglePurchased({{ $row->item->id }})"
                            {{ $row->is_purchased ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>

                    {{-- Delete --}}
                    <button type="button" class="text-red-600 dark:text-red-400 px-2"
                            wire:confirm="Are you sure you want to delete from the list?"
                            wire:click="remove({{ $row->item->id }})">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>


            </li>
        @empty
            <div class="flex items-center justify-center object-fill">
                <img src="{{ asset('assets/Shopping Bag.gif') }}" alt="No items added" class="p-6 w-36 h-36">
            </div>
        @endforelse
    </ul>
</div>
