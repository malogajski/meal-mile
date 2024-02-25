<?php

namespace App\Livewire\Item;

use App\Models\Item;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $items = Item::paginate(5);

        return view('livewire.item.index', compact('items'))->layout('layouts.app');
    }
}
