@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between">
            <h3>{{ __('Warehouse Details') }}</h3>
            <a href="{{ route('back.warehouse.index') }}" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>{{ __('ID') }}</th>
                    <td>{{ $warehouse->id }}</td>
                </tr>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <td>{{ $warehouse->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('Location') }}</th>
                    <td>{{ $warehouse->location }}</td>
                </tr>
                <tr>
                    <th>{{ __('Created At') }}</th>
                    <td>{{ $warehouse->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>{{ __('Updated At') }}</th>
                    <td>{{ $warehouse->updated_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
