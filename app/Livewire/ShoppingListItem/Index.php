<?php

namespace App\Livewire\ShoppingListItem;

use App\Models\ShoppingListItem;
use Livewire\Component;

class Index extends Component
{
    public $shoppingListId;

    protected $listeners = [
        'refreshShippingList' => '$refresh',
    ];

    public function mount($id)
    {
        $this->shoppingListId = $id;
    }

    public function render()
    {
        $shoppingItems = ShoppingListItem::with('item', 'addedByUser')->where('shopping_list_id', $this->shoppingListId)
            ->get();

        return view('livewire.shopping-list-item.index', compact('shoppingItems'))
            ->layout('layouts.app');
    }

    public function remove($id)
    {
        $shoppingListItem = ShoppingListItem::where('shopping_list_id', $this->shoppingListId)
            ->where('item_id', $id)->first();

        $shoppingListItem->delete($id);
        $this->dispatch('refreshShoppingItemCreate');
    }

    public function cancel($id)
    {
        ShoppingListItem::where('shopping_list_id', $this->shoppingListId)
            ->where('item_id', $id)
            ->update([
                'is_purchased'         => 0,
                'purchased_by_user_id' => null,
            ]);
    }

    public function purchased($id)
    {
        $shoppingListItem = ShoppingListItem::where('shopping_list_id', $this->shoppingListId)
            ->where('item_id', $id)->first();

        if (!empty($shoppingListItem)) {
            $shoppingListItem->update([
                'is_purchased'         => 1,
                'purchased_by_user_id' => auth()->user()->id,
            ]);
        }
    }
}
