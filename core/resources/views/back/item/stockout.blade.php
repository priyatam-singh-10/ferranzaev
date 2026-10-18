@extends('master.back')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="mb-0 bc-title"><b>{{ __('Stock Out History') }}</b></h3>
            <a href="{{ route('back.stockout.export') }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-csv"></i> {{ __('Export CSV') }}
            </a>
        </div>
    </div>

    <!-- Stock Out History Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="gd-responsive-table">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <!--<th>{{ __('Warehouse') }}</th>-->
                            <th>{{ __('Quantity Out') }}</th>
                            <th>{{ __('Out By') }}</th>
                            <th>{{ __('Date & Time') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stock_out_history as $history)
                            <tr>
                                <td>{{ $history->product_name }}</td>
                                <!--<td>{{ $history->warehouse_name ?? __('N/A') }}</td>-->
                                <td>{{ $history->qty }}</td>
                                <td>{{ $history->out_status }}</td>
                                <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d M Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">{{ __('No stock out history available') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
