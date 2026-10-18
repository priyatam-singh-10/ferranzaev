@extends('master.back')

@section('content')
<div class="container mt-4">
    <h2>Edit Item Model</h2>

    <form action="{{ route('back.item_model.update', $model->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Model Name</label>
            <input type="text" id="name" name="name" class="form-control" 
                   value="{{ old('name', $model->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ $model->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$model->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('back.item_model.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
