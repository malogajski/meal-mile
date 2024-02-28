<?php

namespace App\Livewire\Item;


use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Carbon\Carbon;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public $name;
    public $lists = [];
    public $categoryId;
    public $subCategoryId;

    protected $listeners = [
        'refreshCreateItem'
    ];

    public function refreshCreateItem()
    {
        $this->getLists();
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        $this->getLists();
    }

    public function render()
    {
        return view('livewire.item.create');
    }

    public function save()
    {
        $data = [
            'team_id'         => auth()->user()->team_id,
            'name'            => $this->name,
            'user_id'         => auth()->user()->id,
            'category_id'     => $this->categoryId,
            'sub_category_id' => $this->subCategoryId,
            'created_at'      => Carbon::now(),
        ];

        $isItemExists = Item::where('team_id', auth()->user()->team_id)
            ->where('name', $this->name)
            ->exists();

        if (!$isItemExists) {
            Item::create($data);
            $this->dispatch('refreshCreateItem');
            $this->closeModal();
        }
    }

    public function updatedCategoryId()
    {
        $this->lists['sub_categories'] = SubCategory::where('category_id', $this->categoryId)->pluck('name', 'id')->toArray();
    }

    public function getLists()
    {
        $this->lists['categories'] = Category::pluck('name', 'id')->toArray();
        if (!empty($this->categoryId)) {
            $this->lists['sub_categories'] = SubCategory::where('category_id', $this->categoryId)->pluck('name', 'id');
        } else {
            $this->lists['sub_categories'] = [];
        }
    }
}
