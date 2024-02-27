<div class="m-6 p-6 bg-white dark:bg-gray-800 dark:text-gray-300 rounded-xl">
    <p class="text-lg font-semibold mb-6">List of Items</p>

    <div x-data="{ createItem:false }" class="mt-2 mb-4 text-gray-700 dark:text-gray-300">
        <x-primary-button @click="createItem = !createItem">Add Item</x-primary-button>
        <div x-show="createItem" class="mt-6">
            <span>Item name:</span>
            <input type="text" class="rounded mr-2 bg-gray-50 dark:bg-gray-800" wire:model="name">
            <x-primary-button wire:click="addItem" @click="createItem = false">Add</x-primary-button>
        </div>
    </div>

    <div class="w-full">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-gray-200 dark:bg-gray-900">
                <th class="p-2">#</th>
                <th>Name</th>
                <th>Added by</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr class="odd:bg-gray-50 dark:odd:bg-gray-700">
                    <td class="px-2 py-2 text-center">{{ $item->id }}</td>
                    <td class="text-center">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->user->name }}</td>
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
