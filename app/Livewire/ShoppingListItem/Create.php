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

    protected $listeners = [
        'refreshShoppingItemCreate' => 'check',
    ];

    public function check()
    {
        $this->dispatch('$refresh');
    }

    public function mount($id)
    {
        $this->added_by_user_id = auth()->user()->id;
        $this->team_id = auth()->user()->team_id;
        $this->shopping_list_id = $id;
        $this->shoppingList = ShoppingList::find($id);
    }

    public function render()
    {
        $alreadyAddedItems = ShoppingListItem::where('shopping_list_id', $this->shopping_list_id)->pluck('item_id')->toArray();
        $query = Item::select(['id', 'name']);

        if (!empty($alreadyAddedItems)) {
            $query->whereNotIn('id', $alreadyAddedItems);
        }

        $items = $query->orderBy('name')
            ->get();

        return view('livewire.shopping-list-item.create', compact('items'))
            ->layout('layouts.app');
    }

    public function add($item)
    {
        $this->item_id = $item['id'];
        $data = $this->all();

        if (isset($data['shoppingList'])) {
            unset($data['shoppingList']);
        }

        ShoppingListItem::insert($data);
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
