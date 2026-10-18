@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between">
            <h3>{{ __('Add New Warehouse') }}</h3>
            <a href="{{ route('back.warehouse.index') }}" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('back.warehouse.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Location') }}</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-secondary">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
