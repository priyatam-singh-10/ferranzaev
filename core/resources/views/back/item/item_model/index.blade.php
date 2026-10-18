@extends('master.back')
@section('content')
<div class="container mt-4">
    <h2>Item Models</h2>

    <a href="{{ route('back.item_model.create') }}" class="btn btn-primary mb-3">+ Add New Model</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th>Created At</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($models as $model)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $model->name }}</td>
                    <td>
                        @if($model->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $model->created_at->format('d M, Y') }}</td>
                    <td>
                        <a href="{{ route('back.item_model.edit', $model->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('back.item_model.destroy', $model->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No models found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $models->links() }}
</div>
@endsection
