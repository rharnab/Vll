<option value="">Select Account</option>
@foreach($accounts as $account)
    {{-- <option value='{{ $account->acc_no  }}'>{{ $account->acc_name }} ({{ $account->acc_no }}) </option> --}}
    <option value='{{ $account->acc_no  }}'>{{ $account->acc_name }} </option>
@endforeach 