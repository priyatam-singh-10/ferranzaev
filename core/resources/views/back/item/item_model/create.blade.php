@extends('master.back')

@section('content')
<div class="container mt-4">
    <h2>Add New Item Model</h2>

    <form action="{{ route('back.item_model.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Model Name</label>
            <input type="text" id="name" name="name" class="form-control" 
                   value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('back.item_model.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
