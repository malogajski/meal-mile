<?php

namespace App\Livewire\Item;

use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{

    protected $listeners = [
        'refreshCreateItem' => '$refresh',
    ];

    public function refreshCreateItem()
    {
        $this->getLists();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $items = Item::with('category', 'subCategory')->orderBy('id', 'desc')->paginate(10);

        return view('livewire.item.index', compact('items'))->layout('layouts.app');
    }

}
