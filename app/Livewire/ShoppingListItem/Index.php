<?php

namespace App\Livewire\ShoppingListItem;

use App\Models\ShoppingListItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $shoppingItems = ShoppingListItem::with('item.category', 'item.subCategory', 'addedByUser')
            ->where('shopping_list_id', $this->shoppingListId)
            ->orderBy('id', 'desc')
            ->orderBy('is_purchased')
            ->get();

        return view('livewire.shopping-list-item.index', compact('shoppingItems'))
            ->layout('layouts.app');
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $shoppingListItem = ShoppingListItem::where('shopping_list_id', $this->shoppingListId)
                ->where('item_id', $id)->first();

            $shoppingListItem->delete();
            $this->dispatch('refreshShoppingItemCreate');
            $this->dispatch('$refresh');
            DB::commit();
            $this->dispatch('alertSuccess', ['title' => __('Success'), 'message' => __('Item has been removed.')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('alertError', ['title' => __('Error'), 'message' => __('Something went wrong while removing item.')]);
            Log::error('Shopping list - remove item error: ' . $e->getMessage());
        }
    }
    public function togglePurchased($id)
    {
        $shoppingListItem = ShoppingListItem::where('shopping_list_id', $this->shoppingListId)
            ->where('item_id', $id)
            ->first();
        $state = !$shoppingListItem->is_purchased;

        try {
            DB::beginTransaction();

            if ($shoppingListItem) {
                $shoppingListItem->update([
                    'is_purchased' => !$shoppingListItem->is_purchased,
                    'purchased_by_user_id' => $shoppingListItem->is_purchased ? null : auth()->user()->id,
                ]);
            }
            DB::commit();
            if ($state) {
                $this->dispatch('alertSuccess', ['title' => __('Success'), 'message' => __('Item purchased successfully.')]);
            } else {
                $this->dispatch('alertSuccess', ['title' => __('Success'), 'message' => __('Item has been canceled.')]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            if ($state) {
                $this->dispatch('alertError', ['title' => __('Error'), 'message' => __('Something went wrong while purchasing.')]);
            } else {
                $this->dispatch('alertError', ['title' => __('Error'), 'message' => __('Something went wrong while canceling item.')]);
            }
            Log::error('Shopping list - change purchase item state error: ' . $e->getMessage());
        }
    }
}
