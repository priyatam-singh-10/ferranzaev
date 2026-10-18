@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between">
            <h3>{{ __('Warehouses') }}</h3>
            <a href="{{ route('back.warehouse.create') }}" class="btn btn-primary btn-sm">{{ __('Add Warehouse') }}</a>
        </div>
    </div>
       <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('Close') }}">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('Close') }}">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- End Flash Message -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warehouses as $warehouse)
                        <tr>
                            <td>{{ $warehouse->id }}</td>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->location }}</td>
                            <td>
                                <a href="{{ route('back.warehouse.show', $warehouse->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('back.warehouse.edit', $warehouse->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('back.warehouse.destroy', $warehouse->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">{{ __('No warehouses found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $warehouses->links() }}
        </div>
    </div>
</div>
@endsection
