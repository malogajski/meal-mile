<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    #[Validate('required|min:2')]
    public string $name;

    public function render()
    {
        return view('livewire.category.create');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'team_id' => auth()->user()->team_id,
            'created_at' => Carbon::now(),
        ];

        $ifCategoryExists = Category::where('team_id', auth()->user()->tema_id)
            ->where('name', $this->name)
            ->exists();

        if (!$ifCategoryExists) {
            Category::create($data);
            $this->dispatch('refreshCreateItem');
            $this->closeModal();
        }
    }
}
