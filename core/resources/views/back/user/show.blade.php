@extends('master.back')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 pl-3"><b>{{ __('Customer Details') }}</b></h3>
                <a class="btn btn-primary btn-sm" href="{{ route('back.user.index') }}">
                    <i class="fas fa-chevron-left"></i> {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
    <!-- Form -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <form action="{{ route('back.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('alerts.alerts')
                <div class="card">
                    <div class="card-body">
                        <div class="gd-responsive-table">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>{{ __("Company Name") }} *</th>
                                    <td>
                                        <input type="text" name="bill_company" class="form-control" value="{{ $user->bill_company }}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Name") }} </th>
                                    <td>
                                        <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" maxlength="100">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>{{ __("Last Name") }}</th>
                                    <td>
                                        <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" maxlength="100">
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>{{ __("Email Address") }} *</th>
                                    <td>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Address1") }} *</th>
                                    <td>
                                        <input type="bill_address1" name="bill_address1" class="form-control" value="{{ $user->bill_address1 }}" maxlength="100" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Address2") }} </th>
                                    <td>
                                        <input type="bill_address2" name="bill_address2" class="form-control" value="{{ $user->bill_address2 }}" maxlength="100">
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("ZipCode") }} *</th>
                                    <td>
                                        <input type="bill_zip" name="bill_zip" class="form-control" value="{{ $user->bill_zip }}" placeholder="{{ __('6-digit Zip Code') }}" maxlength="6" pattern="[0-9]{6}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("City") }} *</th>
                                    <td>
                                        <input type="bill_city" name="bill_city" class="form-control" value="{{ $user->bill_city }}" maxlength="50" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Country") }} *</th>
                                    <td>
                                        <select class="form-control" name="bill_country" id="billing-country" required>
                                            <option selected>{{__('Choose Country')}}</option>
                                            @foreach (DB::table('countries')->get() as $country)
                                            <option value="{{$country->name}}" {{$user->bill_country == $country->name ? 'selected' :''}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Phone Number") }} *</th>
                                    <td>
                                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" maxlength="10" pattern="[0-9]{10}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("GST Number") }} *</th>
                                    <td>
                                        <input type="text" name="gst_number" class="form-control" value="{{ $user->gst_number }}" maxlength="100" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("MSME  Number") }} </th>
                                    <td>
                                        <input type="text" name="msme_number" class="form-control" value="{{ $user->msme_number }}" maxlength="100">
                                    </td>
                                </tr>
                                <tr>
                                   <th>{{ __("Password") }} *</th>
                                    <td>
                                        <input type="password" name="password" class="form-control" placeholder="{{ __('6–10 characters password') }}" minlength="6" maxlength="10" required>
                                    </td>
                                </tr>
                                @php
                                $documents = json_decode($user->documents, true) ?? [];
                                @endphp
                                <tr>
                                    <th>{{ __("Adhar Card") }}</th>
                                    <td>
                                        @if(!empty($documents['adharcard']))
                                        @php $ext = strtolower(pathinfo($documents['adharcard'], PATHINFO_EXTENSION)); @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png','jfif']))
                                        <img src="{{ url('core/public/' . $documents['adharcard']) }}" alt="Adhar Card" style="max-width:200px; max-height:200px; margin-bottom:5px;">
                                        @else
                                        <a href="{{ url('core/public/' . $documents['adharcard']) }}" target="_blank">View File</a>
                                        @endif
                                        @endif
                                        <input type="file" name="adharcard" class="form-control mt-2">
                                        <span class="mt-1 text-info">{{ __('Image Format png, jpg, jpeg and Size 600 x 350') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Pan Card") }}</th>
                                    <td>
                                        @if(!empty($documents['pancard']))
                                        @php $ext = strtolower(pathinfo($documents['pancard'], PATHINFO_EXTENSION)); @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png','jfif']))
                                        <img src="{{ url('core/public/' . $documents['pancard']) }}" alt="Pan Card" style="max-width:200px; max-height:200px; margin-bottom:5px;">
                                        @else
                                        <a href="{{ url('core/public/' . $documents['pancard']) }}" target="_blank">View File</a>
                                        @endif
                                        @endif
                                        <input type="file" name="pancard" class="form-control mt-2">
                                        <span class="mt-1 text-info">{{ __('Image Format png, jpg, jpeg and Size 600 x 350') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("GST Document") }} </th>
                                    <td>
                                        @if(!empty($documents['gstdoc']))
                                        @php $ext = strtolower(pathinfo($documents['gstdoc'], PATHINFO_EXTENSION)); @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png','jfif']))
                                        <img src="{{ url('core/public/' . $documents['gstdoc']) }}" alt="GST Document" style="max-width:200px; max-height:200px; margin-bottom:5px;">
                                        @else
                                        <a href="{{ url('core/public/' . $documents['gstdoc']) }}" target="_blank">View File</a>
                                        @endif
                                        @endif
                                        <input type="file" name="gstdoc" class="form-control mt-2">
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Extra Document") }}</th>
                                    <td>
                                        @if(!empty($documents['extradoc']))
                                        @php $ext = strtolower(pathinfo($documents['extradoc'], PATHINFO_EXTENSION)); @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png','jfif']))
                                        <img src="{{ url('core/public/' . $documents['extradoc']) }}" alt="Extra Document" style="max-width:200px; max-height:200px; margin-bottom:5px;">
                                        @else
                                        <a href="{{ url('core/public/' . $documents['extradoc']) }}" target="_blank">View File</a>
                                        @endif
                                        @endif
                                        <input type="file" name="extradoc" class="form-control mt-2">
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Type") }} *</th>
                                    <td>
                                        <select name="brand_type" class="form-control" required>
                                            <option value="" disabled selected>{{ __('Select Type') }}</option>
                                            <option value="0" {{ $user->tag === 0    ? 'selected' : '' }}>{{ __('Branded') }}</option>
                                            <option value="1" {{ $user->tag === 1 ? 'selected' : '' }}>{{ __('Non-Branded') }}</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Total Orders") }}</th>
                                    <td>{{ count($user->orders) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Joined") }}</th>
                                    <td>
                                        @if($user->created_at)
                                        {{ $user->created_at->diffForHumans() }}
                                        @else
                                        {{ __('Not available') }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-secondary">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection