<div class="modal text-sm">
    <p class="text-xl font-semibold">
        @if(empty($item->id))
            Create
        @else
            Edit
        @endif Item
    </p>
    <div class="w-full mt-2 mb-4 text-gray-700 dark:text-gray-300">
        <form enctype="multipart/form-data" wire:submit.prevent="save" class="mt-6">
            <div class="flex flex-col space-y-2 mb-6">
                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="name" class="text-xs uppercase font-bold">Name</label>
                    <div class="flex items-center space-x-2">
                        <input type="text" class="text-input rounded w-full" id="name" wire:model="name">
                    </div>
                    <div>@error('name') {{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <x-toggle :wire-model="'shoppingList'" :title="'Use for shopping'" id="shoppingList" :use-defer="true"/>
                    @error('shoppingList') <div>{{ $message }}</div>@enderror
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <x-toggle :wire-model="'checkList'" :title="'Use for check list'" id="checkList" :use-defer="true"/>
                    @error('checkList') <div>{{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="category_id" class="text-xs uppercase font-bold">Category</label>
                    <div class="flex items-center flex-row space-x-2">
                        <select name="category_id" id="category_id" wire:model.live="categoryId" class="select w-full">
                            <option value=""></option>
                            @foreach($lists['categories'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-secondary-button wire:click="$dispatch('openModal', {component: 'category.create'})">Add</x-secondary-button>
                    </div>
                    <div>@error('categoryId') {{ $message }} @enderror</div>
                </div>

                <div class="flex flex-col space-y-2 rounded p-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    <label for="sub_category_id" class="text-xs uppercase font-bold">Sub category</label>
                    <div class="flex items-center flex-row space-x-2">
                        <select name="sub_category_id" id="sub_category_id" wire:model="subCategoryId" class="select w-full">
                            <option value=""></option>
                            @foreach($lists['sub_categories'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-secondary-button wire:click="$dispatch('openModal', {component: 'sub-category.create', parameters: {categoryId: '{{$categoryId}}' }})">Add</x-secondary-button>
                    </div>
                    <div>@error('subCategoryId') {{ $message }} @enderror</div>
                </div>
            </div>

            <p>{{ $pathToFile }}</p>
            <div x-data="photoPreviewFeature('{{ $ticket->media[0]['preview_url'] ?? '' }}')">
                <label for="file-input" class="sr-only">Choose file</label>
                <input type="file"
                       name="file-input"
                       class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600
                                            file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-gray-700 dark:file:text-gray-400"
                       wire:model="pathToFile"
                       accept="image/*"
                       id="capture"
                       @change="handleFileChange($event)">

                <div class="relative max-w-full">
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="object-contain" style="max-width: 50%; max-height: 400px;" alt="Image preview...">
                    </template>
                    <canvas x-show="drawing" :width="canvasWidth" :height="canvasHeight" class="absolute top-0 left-0 object-contain w-full h-full" x-ref="canvas" style="border: 1px solid black;"></canvas>
                </div>

                <div class="mt-6">
                    <button type="button" @click="startDrawing()">Start Drawing</button>
                    <button type="button" @click="saveImage()">Save Image</button>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <x-secondary-button wire:click="$dispatch('closeModal')">Close</x-secondary-button>
                <x-primary-button type="button" wire:click="save">Save</x-primary-button>
            </div>
        </form>
    </div>
</div>

@script
<script>
    Alpine.data('photoPreviewFeature', (previewUrl) => {
        return {
            photoPreview: previewUrl,
            drawing: false,
            canvasWidth: 0,
            canvasHeight: 0,
            handleFileChange(event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    this.photoPreview = URL.createObjectURL(file);
                } else {
                    this.photoPreview = previewUrl;
                }
            },
            startDrawing() {
                this.drawing = true;
                this.$nextTick(() => {
                    const img = new Image();
                    img.src = this.photoPreview;
                    img.onload = () => {
                        const canvas = this.$refs.canvas;
                        this.canvasWidth = img.width;
                        this.canvasHeight = img.height;
                        const ctx = canvas.getContext('2d');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0, img.width, img.height);
                        this.setupDrawing(canvas, ctx);
                    };
                });
            },
            setupDrawing(canvas, ctx) {
                let isDrawing = false;
                let rect = canvas.getBoundingClientRect();

                canvas.addEventListener('mousedown', () => {
                    isDrawing = true;
                });
                canvas.addEventListener('mouseup', () => {
                    isDrawing = false;
                    ctx.beginPath();
                });
                canvas.addEventListener('mousemove', (e) => {
                    if (!isDrawing) return;

                    // Calculate coordinates based on canvas dimensions
                    let x = (e.clientX - rect.left) * (canvas.width / rect.width);
                    let y = (e.clientY - rect.top) * (canvas.height / rect.height);

                    ctx.strokeStyle = 'red';
                    ctx.lineWidth = 2;
                    ctx.lineCap = 'round';
                    ctx.lineTo(x, y);
                    ctx.stroke();
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                });
            },
            stopDrawing() {
                this.drawing = false;
            },
            saveImage() {
                const canvas = this.$refs.canvas;
                const dataURL = canvas.toDataURL('image/png');
                @this.call('saveCanvasImage', dataURL);
            }
        };
    });
</script>
@endscript
