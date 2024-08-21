<?php

namespace App\Livewire\Item;


use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;


class Create extends ModalComponent
{
    use WithFileUploads;

    public $name;
    public $lists = [];
    public $categoryId;
    public $subCategoryId;
    public Item $item;
    public $itemId;
    public $pathToFile = '';
    public $checkList = false;
    public $shoppingList = true;

    protected $listeners = [
        'refreshCreateItem',
        'fileSelected',
        'fileUpload',
    ];

    public function fileSelected($file)
    {
        $this->pathToFile = $file;
    }

    public function refreshCreateItem()
    {
        $this->getLists();
        $this->dispatch('$refresh');
    }

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
                    $this->itemId = $value;
                }
            }
        }
        if (!empty($this->itemId)) {
            $this->item = Item::find($this->itemId);
            $this->name = $this->item->name;
            $this->categoryId = $this->item->category_id;
            $this->subCategoryId = $this->item->sub_category_id;
            $this->shoppingList = $this->item->shopping_list;
            $this->checkList = $this->item->check_list;
            $this->pathToFile = $this->item->getMedia('items')->first();
        }

        $this->getLists();
    }

    public function render()
    {
        return view('livewire.item.create');
    }

    public function save()
    {
        $data = [
            'team_id'       => auth()->user()->team_id,
            'name'          => $this->name,
            'user_id'       => auth()->user()->id,
            'category_id'   => $this->categoryId,
            'created_at'    => Carbon::now(),
            'shopping_list' => $this->shoppingList,
            'check_list'    => $this->checkList,
        ];

        if ($this->categoryId) {
            $data['category_id'] = $this->categoryId;
        }

        if ($this->subCategoryId) {
            $data['sub_category_id'] = $this->subCategoryId;
        }

        $isItemExists = Item::where('team_id', auth()->user()->team_id)
            ->where('name', $this->name)
            ->exists();

        $item = Item::find($this->itemId);

        if ($this->itemId) {
            $item->update([
                'name'            => $this->name,
                'category_id'     => $this->categoryId,
                'sub_category_id' => $this->subCategoryId,
                'shopping_list'   => $this->shoppingList,
                'check_list'      => $this->checkList,
                'user_id'         => auth()->user()->id,
            ]);
        } else {
            if (!$isItemExists) {
                $item = Item::create($data);
            }
        }

        if (!empty($this->pathToFile)) {
            usleep(1000);
            $item->clearMediaCollection('items');

            $item->addMedia($this->pathToFile)
                ->toMediaCollection('items');
        }

        $this->dispatch('refreshCreateItem');
        $this->dispatch('refreshShippingList');
        $this->closeModal();
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
    public function saveCanvasImage($dataURL)
    {
        // Decode the Base64 image data
        $data = explode(',', $dataURL)[1];
        $data = base64_decode($data);

        // Create a temporary file and write the decoded image data to it
        $tempFilePath = tempnam(sys_get_temp_dir(), 'canvas');
        file_put_contents($tempFilePath, $data);

        // Add the temporary file to the item's media collection
        if (!empty($this->itemId)) {
            $item = Item::find($this->itemId);
            $item->clearMediaCollection('items');

            $media = $item->addMedia($tempFilePath)
                ->toMediaCollection('items');
        }

        // Update pathToFile with the new image URL
        $this->pathToFile = null;

        // Optionally delete the temporary file
        // unlink($tempFilePath);

        // Dispatch event to refresh the component
        $this->dispatch('refreshCreateItem');
    }

}
