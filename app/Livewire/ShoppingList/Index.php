<?php

namespace App\Livewire\ShoppingList;

use App\Models\ShoppingList;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshShippingList' => '$refresh'
    ];

    public function render()
    {
        $shoppingLists = ShoppingList::paginate(10);

        return view('livewire.shopping-list.index', compact('shoppingLists'))
            ->layout('layouts.app');
    }

    public function newShoppingList()
    {
        return redirect()->route('shopping-list-create');
    }

    public function goToItems($id)
    {
        return redirect()->route('shopping-list-items', $id);
    }
}
