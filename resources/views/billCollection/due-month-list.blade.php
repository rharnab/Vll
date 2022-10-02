<option value="">Select Month</option>

@if(count($all_due_month ) >0)

@foreach($all_due_month as $key => $single_due_month)
@if($key==0)
<option  value="{{ $single_due_month->sold_date }}">{{ date('M-Y', strtotime($single_due_month->sold_date)) }}</option>
@else
<option disabled="" value="">{{ date('M-Y', strtotime($single_due_month->sold_date)) }}</option>
@endif
@sl++;
@endforeach
@endif