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

        {{-- Search for item --}}
        <livewire:components.combo-selector
            :items="$items->toArray()"
            displayField="name"
            imageField="media"
            :optionalFields="['categoryName', 'subCategoryName']"
        />

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
