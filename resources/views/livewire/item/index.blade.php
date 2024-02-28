<div class="m-6 p-6 bg-white dark:bg-gray-800 dark:text-gray-300 rounded-xl">
    <p class="text-lg font-semibold mb-6">List of Items</p>

    <x-secondary-button wire:click="$dispatch('openModal', {component: 'item.create'})" class="my-2">Add Item</x-secondary-button>

    <div class="w-full">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-gray-200 dark:bg-gray-900">
                <th class="p-2">#</th>
                <th>Name</th>
                <th>Category</th>
                <th class="hidden md:block">Sub category</th>
                <th class="hidden md:block">Added by</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr class="odd:bg-gray-50 dark:odd:bg-gray-700">
                    <td class="px-2 py-2 text-center">{{ $item->id }}</td>
                    <td class="text-left">{{ $item->name }}</td>
                    <td class="text-center">
                        @if($item->category) {{ $item->category->name }}@endif
                        <p class="md:hidden">
                            @if($item->subCategory) {{ $item->subCategory->name }}@endif
                        </p>
                    </td>
                    <td class="text-center hidden md:block">@if($item->subCategory) {{ $item->subCategory->name }}@endif</td>
                    <td class="text-center hidden md:block">{{ $item->user->name }}</td>
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
