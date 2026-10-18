@foreach ($datas as $data)
    <tr id="order-bulk-delete">
        <td><input type="checkbox" class="bulk-item" value="{{ $data->id }}"></td>

        <td>
            {{ $data->transaction_number }}
        </td>
        <td>
            {{
                (json_decode(@$data->billing_info, true)['bill_first_name'] ?? '') != ''
                    ? json_decode(@$data->billing_info, true)['bill_first_name']
                    : (json_decode(@$data->billing_info, true)['bill_company_name'] ?? 'N/A')
            }}
        </td>


        <td>
            @if ($setting->currency_direction == 1)
                {{ $data->currency_sign }}{{ PriceHelper::OrderTotal($data) }}
            @else
                {{ PriceHelper::OrderTotal($data) }}{{ $data->currency_sign }}
            @endif
        </td>
             <td>
            @php
                // Use URL directly if doc_image is not null, else use default
                $filePath = $data->doc_image 
                            ? asset('core/public/payment_doc/' . $data->doc_image)
                            : asset('core/public/payment_doc/screenshot_pay.jpg');
            @endphp
    
            <a href="{{ $filePath }}" target="_blank" download>
                <img src="{{ $filePath }}" alt="Document" style="height:50px; width:auto; cursor:pointer;">
            </a>
        </td>

            <td>
                
                 @php
                $total = PriceHelper::OrderTotal($data);
                 $total = floatval(str_replace(',', '', $total));
               
                    $ten_percent = $total * 0.10; // Calculate 10%
                     
               @endphp
                @if ($setting->currency_direction == 1)
                    {{ $data->currency_sign }}{{ $ten_percent }}
                @else
                    {{ $ten_percent}}{{ $data->currency_sign }}
                @endif
            </td>
                   
                   
           <td>
                @if($data->updated_by_name)
                    <strong>{{ $data->updated_by_name }}</strong><br>
                    <small class="text-muted">{{ $data->updated_at->format('d M, Y H:i') }}</small>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>


        <td>
            <div class="dropdown">
                <button
                    class="btn btn-{{ $data->payment_status == 'Paid' ? 'success' : 'danger' }} btn-sm dropdown-toggle"
                    type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    {{ $data->payment_status == 'Paid' ? __('Paid') : __('Unpaid') }}
                </button>
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" data-toggle="modal" data-target="#statusModal" href="javascript:;"
                        data-href="{{ route('back.order.status', [$data->id, 'payment_status', 'Paid']) }}">{{ __('Paid') }}</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#statusModal" href="javascript:;"
                        data-href="{{ route('back.order.status', [$data->id, 'payment_status', 'Unpaid']) }}">{{ __('Unpaid') }}</a>
                </div>
            </div>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn {{ $data->order_status }}  btn-sm dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $data->order_status }}
                </button>
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" data-toggle="modal" data-target="#statusModal" href="javascript:;"
                        data-href="{{ route('back.order.status', [$data->id, 'order_status', 'Pending']) }}">{{ __('Pending') }}</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#statusModal" href="javascript:;"
                        data-href="{{ route('back.order.status', [$data->id, 'order_status', 'In Progress']) }}">{{ __('In Progress') }}</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#statusModal" href="javascript:;"
                        data-href="{{ route('back.order.status', [$data->id, 'order_status', 'Delivered']) }}">{{ __('Delivered') }}</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#statusModal" href="javascript:;"
                        data-href="{{ route('back.order.status', [$data->id, 'order_status', 'Canceled']) }}">{{ __('Canceled') }}</a>
                </div>
            </div>
        </td>
        <td>
            <div class="action-list">
                <a class="btn btn-secondary btn-sm" href="{{ route('back.order.invoice', $data->id) }}">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-info btn-sm " href="{{ route('back.order.edit', $data->id) }}">
                    <i class="fas fa-pen"></i>
                </a>
                <a class="btn btn-danger btn-sm " data-toggle="modal" data-target="#confirm-delete" href="javascript:;"
                    data-href="{{ route('back.order.delete', $data->id) }}">
                    <i class="fas fa-trash-alt"></i>
                </a>

            </div>
        </td>
    </tr>
@endforeach
