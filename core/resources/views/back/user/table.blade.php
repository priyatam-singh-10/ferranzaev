@foreach($datas as $data)
<tr>
    <td>
        {{ $data->bill_company }} 
    </td>
    <td>
        {{ $data->first_name }} 
    </td>
    <td>
        {{ $data->email }}
    </td>
    <td>
        {{ $data->phone }}
    </td>
    <td>
        {{ $data->tag == 0 ? 'Branded' : 'Non Branded' }}
    </td>

    <td>
        <div class="action-list">
            <a class="btn btn-secondary btn-sm "
                href="{{ route('back.user.show',$data->id) }}">
                <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-danger btn-sm " data-toggle="modal"
                data-target="#confirm-delete" href="javascript:;"
                data-href="{{ route('back.user.destroy',$data->id) }}">
                <i class="fas fa-trash-alt"></i>
            </a>
             <a class="btn btn-warning btn-sm " data-toggle="modal" data-target="#changepassword{{ $data->id }}"
                >
                <i class="fas fa-key"></i>
            </a>
        </div>
    </td>
</tr>

<!-- Change password model -->
<div class="modal fade" id="changepassword{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="changepasswordLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="password">
        <form action="{{ route('back.user.changepassword', $data->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changepasswordLabel{{ $data->id }}">{{ __('Change Customer Password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="changepassword" class="form-control"
                               placeholder="{{ __('Password (6–10 characters)') }}" maxlength="10" minlength="6" required>
                    </div>
                    <p class="text-muted">{{ __('Enter a new password for this user.') }}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-info">{{ __('Change') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
