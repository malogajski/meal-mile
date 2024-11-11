<?php

namespace App\Livewire\Item;

use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    protected $listeners = [
        'refreshCreateItem' => '$refresh',
    ];

    public function refreshCreateItem()
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $query = Item::with('category', 'subCategory');
        if (!empty($this->search)) {
            $searchTerm = strtolower($this->search);
            $query->whereRaw('lower(name) like ?', ['%' . $searchTerm . '%'])
                ->orWhereHas('category', function ($query) use ($searchTerm) {
                    $query->whereRaw('lower(name) like ?', ['%' . $searchTerm . '%']);
                })
                ->orWhereHas('subCategory', function ($query) use ($searchTerm) {
                    $query->whereRaw('lower(name) like ?', ['%' . $searchTerm . '%']);
                });
        }

        $query->orderBy('id', 'desc');

        $items = $query->paginate(10);

        return view('livewire.item.index', compact('items'))->layout('layouts.app');
    }

    public function delete($id)
    {
        Item::destroy($id);
        $this->dispatch('$refresh');
    }

//    public function edit($id)
//    {
//        $this->dispatch('open-modal', [
//            'component' => 'item.create',
//            'parameters' => [
//                'id' => $id
//            ]]);
//    }
}
