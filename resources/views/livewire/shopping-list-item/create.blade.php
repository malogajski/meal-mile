<div x-data="{ showItems: false }" class="p-2">
    <div class="mt-3 p-6 bg-white text-gray-700 dark:text-gray-300 rounded-md shadow-xl dark:bg-gray-800">
        <!-- Back Button at the top -->
        <div class="mb-3 flex items-center space-x-3">
            <x-secondary-button onclick="history.back()" class="w-full flex justify-center">
                <i class="fa fa-arrow-alt-circle-left text-lg mr-1"></i> Back
            </x-secondary-button>

            <x-primary-button wire:click="$dispatch('openModal', {component: 'item.create'})" class="w-full flex justify-center">
                <i class="fa fa-plus-circle text-lg mr-1"></i>
                {{ __('Create Item') }}
            </x-primary-button>
        </div>

        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-sm">List of items:</p>
                <p class="font-semibold text-xl">{{ $shoppingList->name ?? 'n-a' }}</p>
            </div>
        </div>

        <div x-data="itemSelector({{ json_encode($items) }})" class="w-full">
            <div x-combobox x-model="selected" x-init="selected = ''">
                <div class="mt-1 relative rounded-md focus-within:ring-2 focus-within:ring-blue-500">
                    <div class="dark:bg-gray-700  ring-2 dark:ring-purple-700 ring-gray-300 flex items-center justify-between gap-2 w-full bg-white pl-5 pr-3 py-2.5 rounded-md shadow">
                        <input
                            x-combobox:input
                            :display-value="item => item ? item.name : ''"
                            @input="query = $event.target.value"
                            class="dark:bg-gray-700 border-none p-0 focus:outline-none focus:ring-0 w-full text-md"
                            placeholder="Search..."
                            x-ref="searchInput"
                        />
                        <button x-combobox:button class="absolute inset-y-0 right-0 flex items-center pr-2">
                            <svg class="shrink-0 w-5 h-5 text-gray-500" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <div x-combobox:options x-cloak
                         class="absolute left-0 w-full max-h-60 mt-2 z-10 origin-top-right overflow-auto bg-white border border-gray-200 rounded-md shadow-md outline-none">
                        <ul class="divide-y divide-gray-100">
                            <template x-for="item in filteredItems" :key="item.id">
                                <li x-combobox:option :value="item" :class="{
                                    'bg-cyan-500/10 text-gray-900': $comboboxOption.isActive,
                                    'text-gray-600': !$comboboxOption.isActive,
                                }" class="flex items-center cursor-default justify-between gap-2 w-full px-4 py-2 text-md">
                                    <img class="rounded-xl shadow w-16 h-16" :src="item.media" alt="img" />
                                    <span x-text="item.name"></span>
                                    <span x-show="$comboboxOption.isSelected" class="text-cyan-600 font-bold">&check;</span>
                                </li>
                            </template>
                        </ul>

                        <p x-show="filteredItems.length == 0" class="px-4 py-2 text-sm text-gray-600">No items match your query.</p>
                    </div>
                </div>

                <x-primary-button class="my-2 w-full text-center flex justify-center"
                                  x-show="selected !== ''"
                                  x-cloak
                                  x-on:click="$wire.call('add', selected); $refs.searchInput.value = ''; query = ''; selected = ''">
                    <i class="fa fa-arrow-alt-circle-down mr-1"></i> Add
                </x-primary-button>

            </div>

        </div>

    </div>

    <div class="mt-6 bg-gray-100 dark:bg-gray-800 w-full p-6 rounded-md">
        <livewire:shopping-list-item.index :id="$shopping_list_id"/>
    </div>
    <script defer src="https://unpkg.com/@alpinejs/ui@3.13.5-beta.0/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/focus@3.13.5/dist/cdn.min.js"></script>
    <script>
        function itemSelector(items) {
            return {
                query: '',
                selected: null,
                items: items,
                get filteredItems() {
                    if (this.query === '') return this.items; // No query - return all

                    const queryLower = this.query.toLowerCase();

                    // Filtering items from query. Checking name, category and subcategory
                    return this.items.filter(item =>
                        item.name.toLowerCase().includes(queryLower) ||
                        (item.categoryName && item.categoryName.toLowerCase().includes(queryLower)) ||
                        (item.subCategoryName && item.subCategoryName.toLowerCase().includes(queryLower))
                    );
                }
            }
        }

    </script>
</div>
@push('scripts')
    <script>
        console.log(@json($items));
    </script>
@endpush
