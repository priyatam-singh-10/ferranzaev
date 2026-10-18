@extends('master.back')
@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><b>{{ __('Edit Variant') }}</b></h3>
            <a href="{{ route('back.variant.index', $item->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('back.variant.update', [$item->id, $variant->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group">
                    <label>Variant Image</label>
                    <input type="file" name="image" class="form-control">
                
                    @if(!empty($variant->image))
                        @php
                            $filePath = asset('core/public/' . $variant->image);
                        @endphp
                        <img src="{{ $filePath }}" width="100" height="100" class="mt-2" alt="Variant Image">
                    @endif
                </div>

                @foreach($attributes as $attribute)
                    <div class="form-group">
                        <label>{{ $attribute->name }}</label>
                        <select name="attributes[{{ $attribute->id }}]" class="form-control">
                            @foreach($attribute->options as $option)
                                <option value="{{ $option->id }}"
                                    {{ $variant->values->where('attribute_id', $attribute->id)->first()?->attribute_option_id == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <div class="form-group">
                    <label>Stock</label>
                    <input type="text" name="stock" class="form-control" value="{{ $variant->stock }}">
                </div>

                <div class="form-group">
                    <label>Price Override (optional)</label>
                    <input type="text" name="price_override" class="form-control" value="{{ $variant->price_override }}">
                </div>

                <button class="btn btn-secondary mt-3">Update Variant</button>
            </form>
        </div>
    </div>
</div>
@endsection
