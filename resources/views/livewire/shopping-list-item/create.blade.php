<div x-data="{ showItems: false }">
    <div class="m-6 p-6 bg-white text-gray-700 dark:text-gray-300 rounded-xl shadow-xl dark:bg-gray-800">
        <!-- Back Button at the top -->
        <div class="flex justify-center">
            <x-secondary-button onclick="history.back()">
                <i class="fa fa-arrow-alt-circle-left mr-1"></i> Back
            </x-secondary-button>
        </div>

        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="text-sm">List of items:</p>
                <p class="font-semibold text-xl">{{ $shoppingList->name ?? 'n-a' }}</p>
            </div>
        </div>


        <div
            x-data="itemSelector({{ json_encode($items) }})"
            class="max-w-xs w-full"
        >
            <div x-combobox x-model="selected">
                <div class="mt-1 relative rounded-md focus-within:ring-2 focus-within:ring-blue-500">
                    <div class="dark:bg-gray-700 flex items-center justify-between gap-2 w-full bg-white pl-5 pr-3 py-2.5 rounded-md shadow">
                        <input
                            x-combobox:input
                            :display-value="item => item ? item.name : ''"
                            @input="query = $event.target.value"
                            class="dark:bg-gray-700 border-none p-0 focus:outline-none focus:ring-0 w-full"
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
                         class="absolute left-0 max-w-xs w-full max-h-60 mt-2 z-10 origin-top-right overflow-auto bg-white border border-gray-200 rounded-md shadow-md outline-none">
                        <ul class="divide-y divide-gray-100">
                            <template
                                x-for="item in filteredItems"
                                :key="item.id"
                            >
                                <li
                                    x-combobox:option
                                    :value="item"
                                    :class="{
                                'bg-cyan-500/10 text-gray-900': $comboboxOption.isActive,
                                'text-gray-600': !$comboboxOption.isActive,
                            }"
                                    class="flex items-center cursor-default justify-between gap-2 w-full px-4 py-2 text-sm"
                                >
                                    <span x-text="item.name"></span>
                                    <span x-show="$comboboxOption.isSelected" class="text-cyan-600 font-bold">&check;</span>
                                </li>
                            </template>
                        </ul>

                        <p x-show="filteredItems.length == 0" class="px-4 py-2 text-sm text-gray-600">No items match your query.</p>
                    </div>
                </div>

                <x-primary-button class="my-2 w-full text-center flex justify-center" x-on:click="$wire.call('add', selected); $refs.searchInput.value = ''; query = ''; selected = ''"><i class="fa fa-arrow-alt-circle-down mr-1"></i> Add</x-primary-button>
            </div>

        </div>

{{--        <div class="w-full flex justify-center my-2 mb-2">--}}
{{--            <x-primary-button @click="showItems = !showItems"--}}
{{--                              x-text="showItems ? 'Hide items' : 'Show items'"--}}
{{--                              class="transition duration-200 ease-in-out transform hover:scale-105"/>--}}
{{--        </div>--}}
{{--        <div class="flex flex-wrap items-start"--}}
{{--             x-show="showItems"--}}
{{--             x-cloak--}}
{{--             x-transition:enter="transition ease-out duration-300"--}}
{{--             x-transition:enter-start="opacity-0 transform scale-90"--}}
{{--             x-transition:enter-end="opacity-100 transform scale-100"--}}
{{--             x-transition:leave="transition ease-in duration-300"--}}
{{--             x-transition:leave-start="opacity-100 transform scale-100"--}}
{{--             x-transition:leave-end="opacity-0 scale-90">--}}
{{--            @foreach($items as $item)--}}
{{--                @php--}}
{{--                    $isInList = \App\Models\ShoppingListItem::where('shopping_list_id', $shopping_list_id)->where('item_id', $item->id)->exists();--}}
{{--                @endphp--}}
{{--                <span--}}
{{--                    class="min-w-20 text-center p-2 rounded transition duration-200 ease-in-out transform hover:-translate-y-1 @if($isInList) bg-gray-400 text-gray-800 @else bg-lime-700 text-white cursor-pointer @endif mx-1 my-1"--}}
{{--                    wire:key="{{ $item->id }}" @if(!$isInList) wire:click="add({{$item->id}})" @else wire:click="remove({{$item->id}})" @endif>{{ $item->name }}</span>--}}
{{--            @endforeach--}}
{{--        </div>--}}
    </div>

    <div class="mt-6 bg-gray-100 dark:bg-gray-800 w-full p-6">
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

        // function itemSelector(items) {
        //     return {
        //         query: '',
        //         selected: null,
        //         items: items,
        //         get filteredItems() {
        //             return this.query === ''
        //                 ? this.items
        //                 : this.items.filter((item) => {
        //                     item.categoryName.toLowerCase().includes(this.query.toLowerCase()) ||
        //                     item.subCategoryName.toLowerCase().includes(this.query.toLowerCase());
        //                 })
        //         },
        //     }
        // }
    </script>
</div>
@push('scripts')
    <script>
        console.log(@json($items));
    </script>
@endpush
