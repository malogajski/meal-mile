<div class="modal text-sm">

    <div class="w-full mt-2 mb-4 text-gray-700 dark:text-gray-300">

        <div class="mt-6">

            <div class="flex flex-col space-y-2 mb-6">
                <div>
                    <span>Item name:</span>
                    <input type="text" class="text-input rounded" wire:model="name">
                    <div>@error('name') {{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="category_id">Category</label>
                    <div class="flex items-center flex-row space-x-2">

                        <select name="category_id" id="category_id" wire:model.live="categoryId" class="select w-full">
                            <option value=""></option>
                            @foreach($lists['categories'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                        <x-secondary-button wire:click="$dispatch('openModal', {component: 'category.create'})">Add</x-secondary-button>
                    </div>
                    <div>@error('categoryId') {{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="sub_category_id">Sub category</label>
                    <div class="flex items-center flex-row space-x-2">
                        <select name="sub_category_id" id="sub_category_id" wire:model="subCategoryId" class="select w-full">
                            <option value=""></option>
                            @foreach($lists['sub_categories'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                        <x-secondary-button wire:click="$dispatch('openModal', {component: 'sub-category.create', parameters: {categoryId: '{{$categoryId}}' }})">Add</x-secondary-button>
                    </div>
                    <div>@error('subCategoryId') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <x-secondary-button wire:click="$dispatch('closeModal')">Close</x-secondary-button>
                <x-primary-button wire:click="save">Save</x-primary-button>
            </div>
        </div>


    </div>
</div>
