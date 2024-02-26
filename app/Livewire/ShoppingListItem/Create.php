<?php

namespace App\Livewire\ShoppingListItem;

use App\Models\Item;
use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use Livewire\Component;

class Create extends Component
{
    public $item_id;
    public $added_by_user_id;
    public $quantity = 1;
    public $price = 1;
    public $shopping_list_id;
    public $team_id;
    public ShoppingList $shoppingList;

    public function mount($id)
    {
        $this->added_by_user_id = auth()->user()->id;
        $this->team_id = auth()->user()->team_id;
        $this->shopping_list_id = $id;
        $this->shoppingList = ShoppingList::find($id);
    }

    public function render()
    {
        $items = Item::paginate(10);

        return view('livewire.shopping-list-item.create', compact('items'))
            ->layout('layouts.app');
    }

    public function add($itemId)
    {
        $this->item_id = $itemId;
        ShoppingListItem::insert($this->all());
        $this->dispatch('refreshShippingList');
    }

    public function remove($itemId)
    {
        ShoppingListItem::where('shopping_list_id', $this->shopping_list_id)->where('item_id', $itemId)->delete();
        $this->dispatch('refreshShippingList');
    }

    public function resetList()
    {
//        ShoppingListItem::where('shopping_list_id', $this->shopping_list_id)->delete();
    }
}
