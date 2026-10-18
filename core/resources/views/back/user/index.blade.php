@extends('master.back')

@section('content')

<!-- Start of Main Content -->
<div class="container-fluid">

	<!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class=" mb-0 "><b>{{ __('Customers List') }}</b></h3>
                 <a href="{{ route('back.user.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> {{ __('Add New Customer') }}
                </a>
                <!-- Export CSV -->
                <a href="{{ route('back.user.export') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-csv"></i> {{ __('Export CSV') }}
                </a>
                                    <!-- Import CSV Modal Trigger -->
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#importCSVModal">
                    <i class="fas fa-file-import"></i> {{ __('Import CSV') }}
                </button>
                <!-- href="https://hel1.your-objectstorage.com/kth-storage/ferranza-image/images/assets/customers_sample.csv" -->
                <!-- href="{{asset('sample_customer\customers_sample.csv')}}" -->
                <a href="https://hel1.your-objectstorage.com/kth-storage/ferranza-image/images/assets/customers_sample.csv"  class="btn btn-primary btn-sm" download>
                    <i class="fas fa-file-import"></i> Download sample CSV
                </a>
                </div>
               
        </div>
        
        
    </div>

	<!-- DataTales -->
	<div class="card shadow mb-4">
		<div class="card-body">
			@include('alerts.alerts')
			<div class="gd-responsive-table">
				<table class="table table-bordered table-striped" id="admin-table" width="100%" cellspacing="0">

					<thead>
						<tr>
                            <th>{{ __('Company name') }}</th>
							<th>{{ __('Name') }}</th>
							<th>{{ __('Email') }}</th>
						    <th>{{ __('Phone') }}</th>
						    <th>{{ __('Type') }}</th>
						     <th>{{ __('Actions') }}</th>
						</tr>
					</thead>

					<tbody>
              			@include('back.user.table',compact('datas'))
					</tbody>

				</table>
			</div>
		</div>
	</div>

</div>

</div>
<!-- End of Main Content -->


{{-- DELETE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

		<!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm Delete?') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
		</div>

		<!-- Modal Body -->
        <div class="modal-body">
			{{ __('You are going to delete this Admin. All contents related with this admin will be lost.') }} {{ __('Do you want to delete it?') }}
		</div>

		<!-- Modal footer -->
        <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
			<form action="" class="d-inline btn-ok" method="POST">

                @csrf

                @method('DELETE')

                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>

			</form>
		</div>

      </div>
    </div>
  </div>

{{-- DELETE MODAL ENDS --}}

<!-- Import CSV Modal -->
<div class="modal fade" id="importCSVModal" tabindex="-1" role="dialog" aria-labelledby="importCSVModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('back.user.import.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="importCSVModalLabel">{{ __('Import Customers CSV') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="csv_file">{{ __('Choose CSV File') }}</label>
                        <input type="file" name="file" class="form-control" id="csv_file" required accept=".csv, .xlsx, .xls">
                    </div>
                    <p class="text-muted">{{ __('Make sure the CSV header matches the database columns.') }}</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-info">{{ __('Import') }}</button>
                </div>

            </div>
        </form>
    </div>
</div>


@endsection
