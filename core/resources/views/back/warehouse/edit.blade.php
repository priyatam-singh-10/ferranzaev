@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between">
            <h3>{{ __('Edit Warehouse') }}</h3>
            <a href="{{ route('back.warehouse.index') }}" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('back.warehouse.update', $warehouse->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $warehouse->name }}" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Location') }}</label>
                    <input type="text" name="location" class="form-control" value="{{ $warehouse->location }}" required>
                </div>
                <button type="submit" class="btn btn-secondary">{{ __('Update') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
