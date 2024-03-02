<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    #[Validate('required|min:2')]
    public string $name;
    public $categoryId;
    public Category $category;

    public function mount(Request $request)
    {
        $requestData = $request->all();

        // access to calls
        $calls = $requestData['components'][0]['calls'];

        $parameters = [];
        foreach ($calls as $call) {
            if (isset($call['params'][1]['parameters'])) {
                $parameters = $call['params'][1]['parameters'];
                // Now we get parameters
                break;
            }
        }

        // parsing 'parameters'
        if (!empty($parameters)) {
            $this->isEdit = true;
            foreach ($parameters as $key => $value) {
                if ($key === 'id') {
                    $this->categoryId = $value;
                }
            }
        }
        if (!empty($this->categoryId)) {
            $this->category = Category::find($this->categoryId);
            $this->name = $this->category->name;
        }
    }

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
