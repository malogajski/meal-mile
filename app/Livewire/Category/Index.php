<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public function render()
    {
        $query = Category::query();

        if (!empty($this->search)) {
            $query->whereRaw('lower(name) like ? ', '%' . strtolower($this->search) . '%');
        }

        $categories = $query->paginate(10);

        return view('livewire.category.index', compact('categories'))
            ->layout('layouts.app');
    }

    public function delete($id)
    {
        Category::destroy($id);
    }
}
