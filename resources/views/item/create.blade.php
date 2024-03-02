<x-app-layout>
    <form method="post" action="{{ route('item.store') }}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="input-group control-group increment" >
            <input type="file" name="image" accept="image/*" capture>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
    </form>
</x-app-layout>
