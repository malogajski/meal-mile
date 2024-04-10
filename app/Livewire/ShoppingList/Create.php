<?php

namespace App\Livewire\ShoppingList;

use App\Enums\ListTypeEnum;
use App\Models\ShoppingList;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{

    #[Validate('required')]
    public $name;
    public $description;
    public $start;
    public $end;
    public $user_id;
    public $team_id;
    public ShoppingList $shoppingList;
    public $shoppingListId;
    public $type;
    public $list = [];

    public function mount($id = null)
    {
        $this->list['type'] = [0 => ListTypeEnum::getDescription(ListTypeEnum::ShoppingList), 1=> ListTypeEnum::getDescription(ListTypeEnum::CheckList)];
        if ($id) {
            $this->shoppingListId = $id;
            $this->shoppingList = ShoppingList::find($id);
            $this->name = $this->shoppingList->name;
            $this->description = $this->shoppingList->description;
            $this->start = $this->shoppingList->start;
            $this->type = $this->shoppingList->type;
        }
        $this->user_id = auth()->user()->id;
        $this->team_id = auth()->user()->team_id;
    }

    public function render()
    {
        return view('livewire.shopping-list.create')
            ->layout('layouts.app');
    }

    public function save()
    {
        $this->validate();

        $data = $this->all();

        if (isset($data['shoppingList'])) {
            unset($data['shoppingList']);
        }

        if (isset($data['shoppingListId'])) {
            unset($data['shoppingListId']);
        }

        if (isset($data['list'])) {
            unset($data['list']);
        }

        if (!empty($this->shoppingListId)) {
            ShoppingList::where('id', $this->shoppingListId)->update($data);
        } else {
            ShoppingList::create($data);
        }

        return redirect()->route('shopping-list');
    }

    public function back()
    {
        return redirect()->route('shopping-list');
    }
}
