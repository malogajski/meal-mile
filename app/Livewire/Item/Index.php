<?php

namespace App\Livewire\Item;

use App\Models\Item;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $name;

    public function render()
    {
        $items = Item::orderBy('id', 'desc')->paginate(10);

        return view('livewire.item.index', compact('items'))->layout('layouts.app');
    }

    public function addItem()
    {
        $data = [
            'team_id'    => auth()->user()->team_id,
            'name'       => $this->name,
            'user_id'    => auth()->user()->id,
            'created_at' => Carbon::now(),
        ];

        $isItemExists = Item::where('team_id', auth()->user()->team_id)
            ->where('name', $this->name)
            ->exists();

        if (!$isItemExists) {
            Item::create($data);
            $this->dispatch('$refresh');
        }
    }
}
