@extends('master.back')
@section('content')
<div class="container mt-4">
    <h2>Item Colors</h2>

    <a href="{{ route('back.item_color.create') }}" class="btn btn-primary mb-3">+ Add New Color</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Color</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($colors as $color)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $color->name }}</td>
                   
                    <td>
                        <span style="background-color:{{ $color->color_code }}; padding: 5px 15px; border: 1px solid #ddd;"></span>
                    </td>
                    <td>
                        @if($color->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $color->created_at->format('d M, Y') }}</td>
                    <td>
                       
                        <a href="{{ route('back.item_color.edit', $color->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('back.item_color.destroy', $color->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No colors found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $colors->links() }}
</div>
@endsection
