<option selected value="0">ALL</option> 
@foreach($all_socks_code as $single_code)
<option value="{{ $single_code->printed_socks_code }}">{{ $single_code->printed_socks_code }} </option>
@endforeach
   