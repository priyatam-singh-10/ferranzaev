@extends('master.back')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 pl-3"><b>{{ __('Add New Customer') }}</b></h3>
                <a class="btn btn-primary btn-sm" href="{{ route('back.user.index') }}">
                    <i class="fas fa-chevron-left"></i> {{ __('Back') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-xl-12">
            <form action="{{ route('back.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('alerts.alerts')

                <div class="card">
                    <div class="card-body">
                        <div class="gd-responsive-table">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>{{ __("Company Name") }} *</th>
                                    <td><input type="text" name="bill_company" class="form-control" placeholder="{{ __('Company Name') }}" maxlength="100" required></td>
                                </tr>

                                <tr>
                                    <th>{{ __("Name") }} </th>
                                    <td><input type="text" name="first_name" class="form-control" placeholder="{{ __('Name') }}" maxlength="100"></td>
                                </tr>
                                <!-- <tr>
                                    <th>{{ __("Last Name") }}</th>
                                    <td><input type="text" name="last_name" class="form-control" placeholder="{{ __('Last Name') }}" maxlength="100"></td>
                                </tr> -->
                                <tr>
                                    <th>{{ __("Email Address") }} *</th>
                                    <td><input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}" required></td>
                                </tr>
                                <tr>
                                    <th>{{ __("Address1") }} *</th>
                                    <td><input type="bill_address1" name="bill_address1" class="form-control" placeholder="{{ __('Address1') }}" maxlength="20" required></td>
                                </tr>
                                <tr>
                                    <th>{{ __("Address2") }} </th>
                                    <td><input type="bill_address2" name="bill_address2" class="form-control" placeholder="{{ __('Address2') }}" maxlength="20"></td>
                                </tr>
                                <tr>
                                    <th>{{ __("ZipCode") }} *</th>
                                    <td><input type="bill_zip" name="bill_zip" class="form-control" placeholder="{{ __('6-digit Zip Code') }}" maxlength="6" pattern="[0-9]{6}" required></td>
                                </tr>
                                <tr>
                                    <th>{{ __("City") }} *</th>
                                    <td><input type="bill_city" name="bill_city" class="form-control" placeholder="{{ __('City') }}" maxlength="20" required></td>
                                </tr>
                                <tr>
                                    <th>{{ __("Country") }} *</th>
                                    <td><select class="form-control" name="bill_country" id="billing-country" required>
                                            <option>{{__('Choose Country')}}</option>
                                            @foreach (DB::table('countries')->get() as $country)
                                            <option value="{{$country->name}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Phone Number") }} *</th>
                                    <td><input type="text" name="phone" class="form-control" placeholder="{{ __('10-digit Phone Number') }}" maxlength="10" pattern="[0-9]{10}" required></td>
                                </tr>
                                <tr>
                                    <th>{{ __("MSME Number") }} </th>
                                    <td><input type="text" name="msme_number" class="form-control" placeholder="{{ __('MSME Number') }}" maxlength="100"></td>
                                </tr>
                                <tr>
                                    <th>{{ __("GST Number") }} *</th>
                                    <td><input type="text" name="gst_number" class="form-control" placeholder="{{ __('GST Number') }}" maxlength="100" required></td>
                                </tr>



                                <tr>
                                    <th>{{ __("Aadhaar Card") }}</th>
                                    <td>
                                        <input type="file" name="adharcard" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <span class="mt-1 text-info">{{ __('Allowed: jpg, jpeg, png, pdf ,doc,docx(Max 512KB)') }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __("PAN Card") }}</th>
                                    <td>
                                        <input type="file" name="pancard" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <span class="mt-1 text-info">{{ __('Allowed: jpg, jpeg, png, pdf,doc,docx (Max 512KB)') }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __("GST Document") }} </th>
                                    <td><input type="file" name="gstdoc" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <span class="mt-1 text-info">{{ __('Allowed: jpg, jpeg, png, pdf,doc,docx (Max 512KB)') }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __("Extra Document") }}</th>
                                    <td><input type="file" name="extradoc" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <span class="mt-1 text-info">{{ __('Allowed: jpg, jpeg, png, pdf,doc,docx (Max 512KB)') }}</span>
                                    </td>
                                </tr>


                                <tr>
                                    <th>{{ __("Password") }} *</th>
                                    <td><input type="password" name="password" class="form-control" placeholder="{{ __('Password (6–10 characters)') }}" minlength="6" maxlength="10" required></td>
                                </tr>

                                <tr>
                                    <th>{{ __("Type") }} *</th>
                                    <td>
                                        <select name="brand_type" class="form-control" required>
                                            <option value="" disabled selected>{{ __('Select Type') }}</option>
                                            <option value="0">{{ __('Branded') }}</option>
                                            <option value="1">{{ __('Non-Branded') }}</option>
                                        </select>
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