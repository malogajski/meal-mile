<div class="md:m-6 md:p-6 bg-white dark:bg-gray-800 dark:text-gray-300 md:rounded-xl">
    <div class="flex items-center justify-between mb-6">
        <p class="text-xl font-semibold mb-6">List of Items</p>
        <x-primary-button wire:click="$dispatch('openModal', {component: 'item.create'})" class="my-2">
            <i class="fa fa-plus mr-1"></i>
            <span class="hidden md:block">Add Item</span>
        </x-primary-button>
    </div>

    <div class="mb-2 flex items-center">
        <label for="search">Search</label>
        <input type="text" class="text-input rounded ml-2 w-full md:w-48" wire:model.live="search">
    </div>

    <div class="w-full text-sm rounded-md overflow-hidden">
        <table class="w-full text-sm rounded-md dark:bg-gray-700">
            <thead>
            <tr class="bg-gray-200 dark:bg-gray-900">
                <th class="p-2">#</th>
                <th>Name</th>
                <th>Category</th>
                <th class="hidden md:table-cell">Sub category</th>
                <th class="hidden md:table-cell">Added by</th>
                <th class="w-24"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr class="odd:bg-gray-50 dark:odd:bg-gray-600">
                    <td class="px-2 py-2 text-center">{{ $item->id }}</td>
                    <td class="text-left w-full">
                        <p>{{ $item->name }}</p>
                        <p class="text-xs text-gray-500 block md:hidden">{{ $item->category->name ?? '' }}</p>
                        <p class="text-xs text-gray-500 block md:hidden">{{ $item->subCategory->name ?? '' }}</p>
                    </td>
                    <td class="text-center hidden md:table-cell">
                        @if($item->category) {{ $item->category->name }}@endif
                        <p class="md:hidden">
                            @if($item->subCategory) {{ $item->subCategory->name }}@endif
                        </p>
                    </td>
                    <td class="text-center hidden md:table-cell">@if($item->subCategory) {{ $item->subCategory->name }}@endif</td>
                    <td class="text-center hidden md:table-cell">{{ $item->user->name }}</td>
                    <td>
                        <div class="flex space-x-2 mx-1">
                            <x-secondary-button wire:click="$dispatch('openModal', {component: 'item.create', parameters: {id: '{{$item->id}}'}})"><i class="fa fa-edit"></i></x-secondary-button>
                            <x-danger-button wire:confirm="Are you sure?" wire:click="delete({{$item->id}})"><i class="fa fa-trash-alt"></i></x-danger-button>
                        </div>
                    </td>
                </tr>
            @empty
                <p>No data</p>
            @endforelse
            </tbody>
        </table>
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </div>
</div>
