@extends('master.back')

@section('content')

<div class="container-fluid">

    <!-- Heading -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><b>{{ __('Add Variant') }}</b></h3>
            <a href="{{ route('back.variant.index', $item->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
        </div>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('back.variant.store', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>{{ __('Variant Image') }}</label>
                    <input type="file" name="image" class="form-control">
                </div>

                @foreach($attributes as $attribute)
                    <div class="form-group">
                        <label>{{ $attribute->name }}</label>
                        <select name="attributes[{{ $attribute->id }}]" class="form-control">
                            <option value="">{{ __('Select '.$attribute->name) }}</option>
                            @foreach($attribute->options as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <div class="form-group">
                    <label>{{ __('Stock') }}</label>
                    <input type="text" name="stock" class="form-control" placeholder="{{ __('Enter Stock') }}">
                    <label class="mt-2">
                        <input type="checkbox" id="unlimited" name="stock_unlimited" value="unlimited"> {{ __('Unlimited Stock') }}
                    </label>
                </div>

                <div class="form-group">
                    <label>{{ __('Price Override') }}</label>
                    <input type="text" name="price_override" class="form-control" placeholder="{{ __('Optional') }}">
                </div>

                <button type="submit" class="btn btn-secondary mt-3">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>

</div>

@endsection
