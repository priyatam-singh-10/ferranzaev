@extends('master.back')

@section('content')
<div class="container mt-4">
    <h2>Add New Item Color</h2>

    <form action="{{ route('back.item_color.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3" > 
            <label>Color</label>

            <div class="d-flex gap-2">

               <input type="color" id="colorPicker" value="{{ old('color_code', '#000000') }}"  style="width: 60px; padding: 0; cursor: pointer;">
               <input type="hidden" name="color_code" id="colorCode" value="{{ old('color_code') }}" required>


            </div>

            @error('color_code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('back.item_color.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

{{-- Interactive Color Picker Script --}}
<script>
    const picker  = document.getElementById("colorPicker");
    const input   = document.getElementById("colorCode");

    // Color preview box (dynamic)
    let preview = document.createElement("div");
    preview.style.width  = "40px";
    preview.style.height = "40px";
    preview.style.border = "1px solid #ccc";
    preview.style.borderRadius = "5px";
    preview.style.marginLeft = "10px";
    preview.style.background = picker.value;
    picker.parentNode.appendChild(preview);

    // Sync when user selects color
    picker.addEventListener("input", function () {
        input.value = this.value;
        preview.style.background = this.value;
    });

    // Validate before submit
    document.querySelector("form").addEventListener("submit", function(e) {
        if (!input.value || input.value.length < 4) {
            alert("Please pick a valid color before submitting.");
            e.preventDefault();
        }
    });
</script>


@endsection
