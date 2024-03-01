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
                    <label for="category_id" class="text-xs uppercase font-bold">Category</label>
                    <div class="flex items-center flex-row space-x-2">

                        <select name="category_id" id="category_id" wire:model="categoryId" class="select w-full">
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

            <div x-data="{ photoPreview: null, photoUrl: @entangle('pathToFile') }">
                <input type="file"
                       wire:model="pathToFile"
                       accept="image/"
                       capture="user"
                       id="capture" @change="photoPreview = $event.target.files.length > 0 ? URL.createObjectURL($event.target.files[0]) : null">

                <template x-if="photoPreview">
                    <img x-bind:src="photoPreview" style="width: 200px; height: 200px;" alt="Image preview...">
                </template>
                <p>Path: <span class="text-red-800">{{ $pathToFile ?? 'n-a' }}</span></p>
                <input type="text" hidden id="img" alt="from phone" wire:model.live="pathToFile">
            </div>

            {{--            <div x-data="{ photoPreview: null, fileChosen(event) { $wire.upload('pathToFile', event.target.files[0]); } }">--}}
            {{--                <input type="file" id="imgInp" @change="fileChosen">--}}

            {{--                <template x-if="photoPreview">--}}
            {{--                    <img x-bind:src="photoPreview" style="width: 200px; height: 200px;" alt="Image preview...">--}}
            {{--                </template>--}}
            {{--                <p>Path: {{ $pathToFile ?? 'n-a' }}</p>--}}
            {{--            </div>--}}

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
