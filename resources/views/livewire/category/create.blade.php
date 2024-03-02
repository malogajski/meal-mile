<div class="p-6 dark:bg-gray-800">

    <div class="dark:text-gray-300 flex flex-col space-y-2">
        <p class="my-6 text-gray-700 dark:text-gray-300 font-semibold text-lg">@if(empty($categoryId)) New @else Edit @endif Category</p>
        <span class="text-gray-700 dark:text-gray-300">Category name:</span>
        <input type="text" class="rounded mr-2 bg-gray-50 dark:bg-gray-700" wire:model="name">
    </div>

    <div class="flex items-center justify-between mt-6">
        <x-secondary-button wire:click="$dispatch('closeModal')">Close</x-secondary-button>
        <x-primary-button wire:click="save">Save</x-primary-button>
    </div>
</div>
