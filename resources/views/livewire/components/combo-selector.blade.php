<div x-data="comboSelector({{ json_encode($items) }})" class="w-full">
    <div x-combobox x-model="selected" x-init="selected = ''">
        <div class="mt-1 relative rounded-md focus-within:ring-2 focus-within:ring-blue-500">
            <div class="dark:bg-gray-700 ring-2 dark:ring-purple-700 ring-gray-300 flex items-center justify-between gap-2 w-full bg-white pl-5 pr-3 py-2.5 rounded-md shadow">
                <input
                    x-combobox:input
                    :display-value="item => item ? item.{{ $displayField }} : ''"
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
                        }" class="flex flex-row items-center cursor-default justify-start gap-2 w-full px-4 py-2 text-md">
                            <template x-if="item.{{ $imageField }}">
                                <img class="rounded-xl shadow w-16 h-16" :src="item.{{ $imageField }}" alt="img"/>
                            </template>

                            <div class="flex flex-col">
                                <span class="text-left" x-text="item.{{ $displayField }}"></span>

                                <template x-for="field in {{ json_encode($optionalFields) }}" :key="field">
                                    <span x-text="item[field]" class="text-xs text-gray-500"></span>
                                </template>
                            </div>

                            <span x-show="$comboboxOption.isSelected" class="text-cyan-600 font-bold">&check;</span>
                        </li>
                    </template>
                </ul>

                <p x-show="filteredItems.length == 0" class="px-4 py-2 text-sm text-gray-600">No items match your query.</p>
            </div>
        </div>

        <button class="my-2 w-full text-center flex justify-center bg-blue-500 text-white px-4 py-2 rounded"
                x-show="selected !== ''"
                x-cloak
                x-on:click="$wire.call('add', selected); $refs.searchInput.value = ''; query = ''; selected = ''">
            <i class="fa fa-arrow-alt-circle-down mr-1"></i> Add
        </button>
    </div>

    <script>
        function comboSelector(items) {
            return {
                query: '',
                selected: null,
                items: items,
                get filteredItems() {
                    if (this.query === '') return this.items;
                    const queryLower = this.query.toLowerCase();
                    return this.items.filter(item =>
                        Object.keys(item).some(key => String(item[key]).toLowerCase().includes(queryLower))
                    );
                }
            }
        }
    </script>
</div>
