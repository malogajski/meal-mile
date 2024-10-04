<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ComboSelector extends Component
{
    public $items = [];
    public $selectedItem = null;
    public $displayField = 'name';
    public $imageField = 'media';
    public $optionalFields = [];

    public function mount(array $items, $displayField = 'name', $imageField = 'media', $optionalFields = []): void
    {
        $this->items = $items;
        $this->displayField = $displayField;
        $this->imageField = $imageField;
        $this->optionalFields = $optionalFields;
    }

    public function add($selectedItem): void
    {
        $this->dispatch('itemAdded', $selectedItem);
        $this->selectedItem = null;
    }

    public function render()
    {
        return view('livewire.components.combo-selector');
    }
}
/*
 *** How to use - on parent view add this ***
    @php
        $users = \App\Models\User::pluck('name', 'id')->map(function ($name, $id) {
            return ['id' => $id, 'name' => $name, 'media' => 'https://via.placeholder.com/64'];
        })->values()->toArray();
    @endphp

    <livewire:components.combo-selector
        :items="$users"
        displayField="name"
        imageField="media"
        :optionalFields="['categoryName', 'subCategoryName']"
    />

    For Items we use additional data:
    <livewire:components.combo-selector
        :items="$items->toArray()"
        displayField="name"
        imageField="media"
        :optionalFields="['categoryName', 'subCategoryName']"
    />

 */
