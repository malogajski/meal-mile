<?php

namespace App\Livewire\SubCategory;

use App\Models\SubCategory;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public function render()
    {
        $query = SubCategory::with('category');

        if (!empty($this->search)) {
            $query->whereRaw('lower(name) like ? ', '%' . strtolower($this->search) . '%');
        }

        $subCategories = $query->paginate(10);

        return view('livewire.sub-category.index', compact('subCategories'))
            ->layout('layouts.app');
    }

    public function delete($id)
    {
        SubCategory::destroy($id);
    }
}
