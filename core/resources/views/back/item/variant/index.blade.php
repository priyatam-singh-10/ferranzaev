@extends('master.back')
@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><b>{{ __('Item Variants') }}</b></h3>
            <a href="{{ route('back.variant.create', $item->id) }}" class="btn btn-sm btn-primary">+ Add Variant</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Attributes</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($variants as $variant)
                    <tr>
                        
                         <td>
                            @php
                              
                                $filePath = $variant->image 
                                            ? asset('core/public/' . $variant->image)
                                            : asset('core/public/screenshot_pay.jpg');
                            @endphp
                    
                           
                                <img src="{{ $filePath }}"  width="60" height="60" alt="Variant Image">
                        
                        </td>
                       
                        <td>
                            @foreach($variant->values as $value)
                                <strong>{{ $value->attribute->name }}</strong>: {{ $value->option->name }}<br>
                            @endforeach
                        </td>
                        <td>{{ $variant->stock }}</td>
                        <td>{{ $variant->price_override }}</td>
                        <td>
                            <a href="{{ route('back.variant.edit', [$item->id, $variant->id]) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('back.variant.destroy', [$item->id, $variant->id]) }}" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this variant?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
