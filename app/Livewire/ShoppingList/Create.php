<?php

namespace App\Livewire\ShoppingList;

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

    public function mount()
    {
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

        ShoppingList::create($this->all());

        return redirect()->route('shopping-list');
    }

    public function back()
    {
        return redirect()->back();
    }
}
