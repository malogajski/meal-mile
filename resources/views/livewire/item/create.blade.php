<div class="modal text-sm">
    <p class="text-xl font-semibold">@if(empty($item->id)) Create @else Edit @endif Item</p>
    <div class="w-full mt-2 mb-4 text-gray-700 dark:text-gray-300">

        <form enctype="multipart/form-data" wire:submit="save" class="mt-6">

            <div class="flex flex-col space-y-2 mb-6">

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="name" class="text-xs uppercase font-bold">Name</label>
                    <div class="flex items-center space-x-2">
                        <input type="text" class="text-input rounded w-full" id="name" wire:model="name">
                    </div>
                    <div>@error('name') {{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="shoppingList" class="text-xs uppercase font-bold">Use for shopping</label>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" class="text-input rounded" id="shoppingList" wire:model="shoppingList">
                    </div>
                    <div>@error('shoppingList') {{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="checkList" class="text-xs uppercase font-bold">Use for check list</label>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" class="text-input rounded" id="checkList" wire:model="checkList">
                    </div>
                    <div>@error('checkList') {{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="category_id" class="text-xs uppercase font-bold">Category</label>
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
                    <label for="sub_category_id" class="text-xs uppercase font-bold">Sub category</label>
                    <div class="flex items-center flex-row space-x-2">
                        <select name="sub_category_id" id="sub_category_id" wire:model="subCategoryId" class="select w-full">
                            <option value=""></option>
                            @foreach($lists['sub_categories'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                        <x-secondary-button wire:click="$dispatch('openModal', {component: 'sub-category.create', parameters: {categoryId: '{{$categoryId}}' }})">Add
                        </x-secondary-button>
                    </div>
                    <div>@error('subCategoryId') {{ $message }} @enderror</div>
                </div>
            </div>

            <div x-data="{ photoPreview: null }">
                <label for="file-input" class="sr-only">Choose file</label>
                <input type="file"
                       name="file-input"
                       class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600
                        file:bg-gray-50 file:border-0
                        file:me-4
                        file:py-3 file:px-4
                        dark:file:bg-gray-700 dark:file:text-gray-400"
                       wire:model="pathToFile"
                       accept="image/"
                       id="capture" @change="photoPreview = $event.target.files.length > 0 ? URL.createObjectURL($event.target.files[0]) : null">

                <template x-if="photoPreview">
                    <img x-bind:src="photoPreview" class="object-contain h-48 w-96" alt="Image preview...">
                </template>
            </div>

            <div class="flex items-center justify-between mt-6">
                <x-secondary-button wire:click="$dispatch('closeModal')">Close</x-secondary-button>
                {{--                <x-primary-button wire:click="save">Save</x-primary-button>--}}
                <x-primary-button type="submit">Save</x-primary-button>
            </div>
        </form>
    </div>
</div>

@script
<script>
    let input = document.getElementById('capture');
    let img = document.getElementById('img');

    input.addEventListener('change', (ev) => {
        // console.log('file input: ' + input.files[0]);
        // img.src = window.URL.createObjectURL(input.files[0]);
        if (input.files[0].type.indexOf("image/") > -1) {
            let img = document.getElementById('img');
            img.value = window.URL.createObjectURL(input.files[0]);
            Livewire.dispatch('fileUpload', input.files[0]);
        }
    });

    // document.addEventListener('DOMContentLoaded', (ev) => {
    //
    // });
    console.log('End DOM');

    Livewire.on('fileChosen', () => {
        let inputField = document.getElementById('imgInp');
        let file = inputField.files[0];
        console.log('fileChosen CHECK!')
        if (file) {
            let reader = new FileReader();
            reader.onloadend = () => {
                // additional action here
                console.log('what now?')
            };
            reader.readAsDataURL(file);
        }
    });

    Alpine.data('photoPreviewFeature', () => ({
        photoPreview: null,


        init() {
            console.log('Alpine part CHECK!')
            this.$watch('photoPreview', value => {
                if (value) {
                    photoUrl = value;
                    console.log(value)
                    // here we can add something like this.$wire.call('save');
                }
            });
        }
    }))
</script>
@endscript
