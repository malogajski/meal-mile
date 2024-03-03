<?php

namespace App\Livewire\ShoppingList;

use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshShippingList' => '$refresh',
    ];

    public function render()
    {
        $shoppingLists = ShoppingList::with('items')->paginate(10);

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

    public function edit($shoppingListId)
    {
        return redirect()->route('shopping-list-edit', ['id' => $shoppingListId]);
    }

    public function delete($shoppingListId)
    {
        try {
            DB::beginTransaction();
            ShoppingListItem::where('shopping_list_id', $shoppingListId)->delete();
            ShoppingList::destroy($shoppingListId);
            DB::commit();
            $this->dispatch('$refresh');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

//    public function sendTestEmail()
//    {
//        $user = User::find(auth()->user()->id);
//        $user->notify(new UserNotification());
//    }
}
