@extends('master.back')

@section('content')

<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Stock In Products') }}</b></h3>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @include('alerts.alerts')

            <div class="gd-responsive-table">
                <table class="table table-bordered table-striped" id="admin-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" data-target="product-bulk-delete" class="form-control bulk_all_delete"></th>
                            <th>{{ __('Image') }}</th>
                            <th width="30%">{{ __('Name') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Stock') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr id="product-bulk-delete">
                            <td><input type="checkbox" class="bulk-item" value="{{ $data->id }}"></td>
                            <td>
                                <img src="{{ $data->thumbnail ? url($data->thumbnail) : url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/placeholder.png') }}"
                                    alt="Image Not Found" width="60">
                            </td>
                            <td>{{ $data->name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-{{ $data->status == 1 ? 'success' : 'danger' }} btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        {{ $data->status == 1 ? __('Publish') : __('Unpublish') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('back.item.status',[$data->id,1]) }}">{{ __('Publish') }}</a>
                                        <a class="dropdown-item" href="{{ route('back.item.status',[$data->id,0]) }}">{{ __('Unpublish') }}</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="{{ $data->is_type != 'undefine' ? 'bg-info badge text-white' : '' }}">
                                    @if($data->is_type == 'undefine')
                                    {{ __('Not Define') }}
                                    @else
                                    {{ ucfirst(str_replace('_',' ',$data->is_type)) }}
                                    @endif
                                </p>
                            </td>
                            <td>{{ $data->stock !== null ? $data->stock : 0 }}</td>
                            <td>

                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        {{ __('Options') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        @php
                                        // Get last stock_out and stock_in for this product
                                        $lastStockOut = DB::table('stock_out')
                                        ->where('product_id', $data->id)
                                        ->orderBy('id', 'desc')
                                        ->first();

                                        $lastStockIn = DB::table('stock_in')
                                        ->where('product_id', $data->id)
                                        ->orderBy('id', 'desc')
                                        ->first();

                                        // Determine visibility of Edit Stock
                                        $showEditStock = true;

                                        if ($lastStockOut && $lastStockOut->non_editable == 1) {
                                        // If stock_out is locked and newer than stock_in → hide Edit
                                        if (!$lastStockIn || $lastStockOut->created_at > $lastStockIn->created_at) {
                                        $showEditStock = false;
                                        }
                                        }
                                        @endphp

                                        @if ($data->item_type == 'normal')
                                        {{-- Always show "In Stock" --}}
                                        <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#updateStockModal{{ $data->id }}">
                                            <i class="fas fa-boxes"></i> {{ __('In Stock') }}
                                        </a>

                                        {{-- Show "Edit Stock" based on logic --}}
                                        @if($showEditStock)
                                        <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#updateStockModalout{{ $data->id }}">
                                            <i class="fas fa-boxes"></i> {{ __('Edit Stock') }}
                                        </a>
                                        @endif
                                        @endif

                                        <a class="dropdown-item" href="{{ route('back.item.highlight', $data->id) }}">
                                            <i class="fas fa-angle-double-right"></i> {{ __('Highlight') }}
                                        </a>

                                        <a class="dropdown-item" data-toggle="modal" data-target="#confirm-delete" href="javascript:;"
                                            data-href="{{ route('back.item.destroy', $data->id) }}">
                                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                                        </a>
                                    </div>

                                </div>

                                {{-- Stock In Modal --}}
                                <div class="modal fade" id="updateStockModal{{ $data->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                        <form action="{{ route('back.item.updateStock', $data->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('Update Stock for') }} {{ $data->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group" style="display:none;">
                                                        <label>{{ __('Warehouse') }}</label>
                                                        <select name="warehouse_id" class="form-control" required>
                                                            @foreach(\App\Models\Warehouse::all() as $warehouse)
                                                            <option value="{{ $warehouse->id }}" selected>{{ $warehouse->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Stock Quantity') }}</label>
                                                        <input type="number" name="qty" class="form-control" required min="0">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Update Stock') }}</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- Stock Out Modal --}}
                                <div class="modal fade" id="updateStockModalout{{ $data->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                        @php
                                        $lastStockOut = DB::table('stock_out')
                                        ->where('product_id', $data->id)
                                        ->orderBy('id', 'desc')
                                        ->first();
                                        $lastLocked = $lastStockOut && $lastStockOut->non_editable == 1;
                                        @endphp
                                        <form action="{{ route('back.item.byadmin', $data->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('Update Stock for') }} {{ $data->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group" style="display:none;">
                                                        <label>{{ __('Warehouse') }}</label>
                                                        <select name="warehouse_id" class="form-control" required>
                                                            @foreach(\App\Models\Warehouse::all() as $warehouse)
                                                            <option value="{{ $warehouse->id }}" selected>{{ $warehouse->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>{{ __('Stock Quantity') }}</label>
                                                        <input
                                                            type="number"
                                                            name="qty"
                                                            class="form-control"
                                                            required
                                                            min="0"
                                                            value=""> {{-- no prefill now --}}


                                                    </div>
                                                    <div class="modal-footer">
                                                        {{-- Always show 3 buttons --}}
                                                        <button type="submit" name="action" value="edit" class="btn btn-success">
                                                            {{ __('Update') }}
                                                        </button>

                                                        @if(Auth::check() && Auth::user()->role_id == 0)
                                                        <button type="submit" name="action" value="lock" class="btn btn-warning">
                                                            {{ __('Save & Lock') }}
                                                        </button>
                                                        @endif

                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            {{ __('Cancel') }}
                                                        </button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>





                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Stock-In History --}}
            <div class="d-flex justify-content-between align-items-center mt-5">
                <h4>{{ __('Stock In History') }}</h4>
                <a href="{{ route('back.stockin.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-file-csv"></i> {{ __('Export CSV') }}
                </a>
            </div>

            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Quantity Added') }}</th>
                        <th>{{ __('Date & Time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stock_history as $history)
                    <tr>
                        <td>{{ $history->product_name }}</td>
                        <td>{{ $history->qty }}</td>
                        <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d M Y h:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">{{ __('No stock history available') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection