@extends('master.front')
@section('title')
{{__('Dashboard')}}
@endsection
@section('content')

<!-- Page Title-->
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index')}}">{{__('Home')}}</a> </li>
                    <li class="separator"></li>
                    <li>{{__('Welcome Back')}}, {{$user->first_name}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page Content-->
<div class="container padding-bottom-3x mb-1">
    <div class="row">
        @include('includes.user_sitebar')
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="padding-top-2x mt-2 hidden-lg-up"></div>
                    <form class="row" action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avater" class="form-label">{{ __('Profile Photo') }}</label>
                                <input class="form-control" type="file" name="photo" id="avater" accept="image/*">
                                @error('photo')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_company">{{ __('Company Name') }}</label>
                                <input
                                    class="form-control"
                                    name="bill_company"
                                    type="text"
                                    id="bill_company"
                                    value="{{ $user->bill_company }}"
                                    maxlength="50"
                                    placeholder="Enter your company name"
                                    required>
                                @error('bill_company')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_address1">{{ __('Address') }}</label>
                                <input
                                    class="form-control"
                                    name="bill_address1"
                                    type="text"
                                    id="bill_address1"
                                    value="{{ $user->bill_address1 }}"
                                    maxlength="50"
                                    placeholder="Enter your Address"
                                    required>
                                @error('bill_address1')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_city">{{ __('City') }}</label>
                                <input
                                    class="form-control"
                                    name="bill_city"
                                    type="text"
                                    id="bill_city"
                                    value="{{ $user->bill_city }}"
                                    maxlength="50"
                                    placeholder="Enter your City"
                                    required>
                                @error('bill_city')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                         <div class="{{DB::table('states')->count() > 0  ? 'col-md-12' : 'col-md-6'}} ">
                      <div class="form-group">
                         <label for="bill-country">{{__('Country')}}</label>
                         <select class="form-control" name="bill_country" id="bill-country">
                            <option>{{__('Choose Country')}}</option>
                            @foreach (DB::table('countries')->get() as $country)
                            <option value="{{$country->name}}" {{$user->bill_country == $country->name ? 'selected' :''}} >{{$country->name}}</option>
                            @endforeach
                         </select>
                         @error('bill_country')
                         <p class="text-danger">{{$message}}</p>
                         @endif
                      </div>
                   </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_zip">{{ __('Zip Code') }}</label>
                                <input
                                    class="form-control"
                                    name="bill_zip"
                                    type="text"
                                    id="bill_zip"
                                    value="{{ $user->bill_zip }}"
                                    maxlength="50"
                                    placeholder="Enter your Zip Code"
                                    required>
                                @error('bill_zip')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-fn">{{ __('Name') }}</label>
                                <input
                                    class="form-control"
                                    name="first_name"
                                    type="text"
                                    id="account-fn"
                                    value="{{ $user->first_name }}"
                                    maxlength="20"
                                    oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');"
                                    placeholder="Enter first name"
                                    >
                                @error('first_name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-ln">{{ __('Last Name') }}</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    name="last_name"
                                    id="account-ln"
                                    value="{{ $user->last_name }}"
                                    maxlength="20"
                                    oninput="this.value=this.value.replace(/[^A-Za-z]/g,'');"
                                    placeholder="Enter last name"
                                    required>
                                @error('last_name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div> -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-email">{{ __('E-mail Address') }}</label>
                                <input
                                    class="form-control"
                                    name="email"
                                    type="email"
                                    id="account-email"
                                    value="{{ $user->email }}"
                                    maxlength="50"
                                    placeholder="Enter your email address"
                                    required>
                                @error('email')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gst_number">{{ __('GST Number') }}</label>
                                <input
                                    class="form-control"
                                    name="gst_number"
                                    type="text"
                                    id="gst_number"
                                    value="{{ $user->gst_number }}"
                                    maxlength="50"
                                    placeholder="Enter GST number"
                                    required>
                                @error('gst_number')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="msme_number">{{ __('MSME Number') }}</label>
                                <input
                                    class="form-control"
                                    name="msme_number"
                                    type="text"
                                    id="msme_number"
                                    value="{{ $user->msme_number }}"
                                    maxlength="50"
                                    placeholder="Enter MSME number"
                                    required>
                                @error('msme_number')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-phone">{{ __('Phone Number') }}</label>
                                <input
                                    class="form-control"
                                    name="phone"
                                    type="text"
                                    id="account-phone"
                                    value="{{ $user->phone }}"
                                    maxlength="14"
                                    pattern="^\+?\d{7,13}$"
                                    oninput="this.value=this.value.replace(/(?!^\+)\D/g,'');"
                                    placeholder="+911234567890"
                                    required>
                                @error('phone')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <h5 class="mb-3"><b>{{ __("Upload Documents") }}</b></h5>

                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">{{ __("Aadhaar Card") }}</th>
                                    <td>
                                        <input type="file" name="adharcard" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <small class="text-info">
                                            {{ __('Allowed: jpg, jpeg, png, pdf, doc, docx (Max 512KB)') }}
                                        </small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __("PAN Card") }}</th>
                                    <td>
                                        <input type="file" name="pancard" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <small class="text-info">
                                            {{ __('Allowed: jpg, jpeg, png, pdf, doc, docx (Max 512KB)') }}
                                        </small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __("GST Document") }}</th>
                                    <td>
                                        <input type="file" name="gstdoc" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <small class="text-info">
                                            {{ __('Allowed: jpg, jpeg, png, pdf, doc, docx (Max 512KB)') }}
                                        </small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __("Extra Document") }}</th>
                                    <td>
                                        <input type="file" name="extradoc" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <small class="text-info">
                                            {{ __('Allowed: jpg, jpeg, png, pdf, doc, docx (Max 512KB)') }}
                                        </small>
                                    </td>
                                </tr>
                            </table>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-pass">{{ __('New Password') }}</label>
                                <input
                                    class="form-control"
                                    name="password"
                                    type="password"
                                    id="account-pass"
                                    minlength="6"
                                    placeholder="{{ __('Change your password') }}">
                                @error('password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="mt-2 mb-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="custom-control custom-checkbox d-block">
                                    <input class="custom-control-input" name="newsletter" type="checkbox" id="subscribe_me" {{ $check_newsletter ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="subscribe_me">{{ __('Subscribe') }}</label>
                                </div>
                                <button class="btn btn-primary margin-right-none" type="submit">
                                    <span>{{ __('Update Profile') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection