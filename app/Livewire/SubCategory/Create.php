<?php

namespace App\Livewire\SubCategory;

use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;

use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    #[Validate('required|min:2')]
    public string $name;

//    public $lists = [];
    public $categoryId;
    public Category $category;
    public $subCategoryId;
    public SubCategory $subCategory;

    public function mount(Request $request, $categoryId = null)
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
            foreach ($parameters as $key => $value) {
                if ($key === 'categoryId') {
                    $this->categoryId = $value;
                }
            }
        }
        if (!empty($this->categoryId)) {
            $this->category = Category::find($this->categoryId);
        }
    }

    public function render()
    {
        return view('livewire.sub-category.create');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'team_id' => auth()->user()->team_id,
            'category_id' => $this->categoryId,
            'created_at' => Carbon::now(),
        ];

        $ifCategoryExists = SubCategory::where('team_id', auth()->user()->team_id)
            ->where('name', $this->name)
            ->where('name', $this->categoryId)
            ->exists();

        if (!$ifCategoryExists) {
            SubCategory::create($data);
            $this->dispatch('refreshCreateItem');
            $this->closeModal();
        }
    }

//    public function getLists()
//    {
//        $this->lists['categories'] = Category::pluck('name', 'id')->toArray();
//        $this->lists['sub_categories'] = [];
//    }
}
