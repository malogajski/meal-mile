<div class="m-6 p-6 bg-white text-gray-700 dark:text-gray-300 rounded-xl shadow-xl dark:bg-gray-800">
    <p class="my-6">List of items ({{ $shopping_list_id ?? 'n-a' }})</p>
    <div class="flex flex-wrap items-start">
        @foreach($items as $item)
            @php
                $isInList = \App\Models\ShoppingListItem::where('shopping_list_id', $shopping_list_id)->where('item_id', $item->id)->exists();
            @endphp
            <span class="p-2 rounded @if($isInList) bg-gray-400 @else bg-lime-700 text-white cursor-pointer @endif mx-1 my-1" wire:key="{{ $item->id }}" @if(!$isInList) wire:click="add({{$item->id}})"@endif>{{ $item->name }}</span>
        @endforeach
    </div>

    <div class="mt-6">
        <livewire:shopping-list-item.index :id="$shopping_list_id"/>
    </div>
</div>
