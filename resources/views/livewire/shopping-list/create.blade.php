<div class="m-6 p-6 bg-white dark:bg-gray-800 dark:text-gray-300 rounded-xl">
    <p class="text-lg font-semibold mb-6">@if(!empty($shoppingListId)) Edit @else New @endif Shopping list</p>

    <div class="mb-4 flex flex-col">
        <label for="name">Name</label>
        <input type="text" id="name" class="rounded dark:bg-gray-700 dark:text-gray-300" wire:model="name">
        <div>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-4 flex flex-col">
        <label for="description">Description</label>
        <textarea id="description" class="rounded dark:bg-gray-700 dark:text-gray-300" wire:model="description"></textarea>
        <div>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-4 flex flex-col">
        <label for="start">Start</label>
        <input type="datetime-local" id="start" class="rounded dark:bg-gray-700 dark:text-gray-300" wire:model="start">
        <div>
            @error('start') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-4 flex flex-col">
        <label for="end">End</label>
        <input type="datetime-local" id="end" class="rounded dark:bg-gray-700 dark:text-gray-300" wire:model="end">
        <div>
            @error('end') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mt-6 flex items-center space-x-5">
        <x-secondary-button wire:click="back" wire:click="back">Back</x-secondary-button>
        <x-primary-button wire:click="save">Save</x-primary-button>
    </div>

</div>
