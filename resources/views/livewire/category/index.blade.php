<div class="p-2 text-gray-700 dark:text-gray-300">
    <div class="flex flex-col w-full xl:w-1/2">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="border rounded-lg divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                    <div class="py-3 px-4 flex items-center justify-between">
                        <div class="relative max-w-xs">
                            <label class="sr-only">Search</label>
                            <input type="text" name="search" wire:model.live="search" id="hs-table-with-pagination-search"
                                   class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                   placeholder="Search for items">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.3-4.3"/>
                                </svg>
                            </div>
                        </div>
                        <x-secondary-button wire:click="$dispatch('openModal', {component: 'category.create'})">
                            <i class="fa fa-plus mr-1"></i>
                            Add
                        </x-secondary-button>
                    </div>
                    <div class="overflow-hidden">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="py-3 px-4 pe-0">
                                    <div class="flex items-center h-5">
                                        <input id="hs-table-pagination-checkbox-all" type="checkbox"
                                               class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                        <label for="hs-table-pagination-checkbox-all" class="sr-only">Checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($categories as $category)
                                <tr wire:key="{{ $category->id }}">
                                    <td class="py-3 ps-4">
                                        <div class="flex items-center h-5">
                                            <input id="hs-table-pagination-checkbox-1" type="checkbox"
                                                   class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                            <label for="hs-table-pagination-checkbox-1" class="sr-only">Checkbox</label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <button type="button" wire:click="$dispatch('openModal', {component: 'category.create', parameters: {id: '{{$category->id}}'}})">
                                            <i class="fa fa-edit mr-4"></i>
                                        </button>

                                        <button type="button"
                                                wire:confirm="Are you sure?"
                                                wire:click="delete({{$category->id}})"
                                                class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <p>No data</p>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="py-1 px-4">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
