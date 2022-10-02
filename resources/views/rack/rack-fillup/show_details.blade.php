

<div class="row">
	<div class="col-md-4">


		<table class="table table-bordered table-sm ">
			
			<tr class="bg-info text-white ">
				<th>No</th>
				<th>Type </th>
				<th>Total</th>
			</tr>

			@php $sl=1;$sum=0; @endphp
			@foreach($get_data as $single_get_data)
				@php 
					$sum= $sum + $single_get_data->total;
				@endphp
				<tr >
					<td>{{$sl++}}</td>	
					<td>{{$single_get_data->types_name}}</td>
					<td>{{$single_get_data->total}} Pair</td>	
						
				</tr>

				

			@endforeach

			<tr>
				<td colspan="2">Total = </td>
				<td> {{$sum}} Pair</td>
			</tr>
		</table>

	</div>

	<div class="col-md-8">
		<table class="table table-bordered table-sm table-responsive" style="width: 90%;">
			<tr class="bg-info text-white ">
				<th>Packet Code</th>
				<th>Type </th>
				<th>Brand</th>
				<th>Size</th>
				<th>Remaining Socks</th>
			</tr>

			@php $sum2=0; @endphp
			@foreach($get_data2 as $single_get_data2)
				@php 
					$sum2 = $sum2 + $single_get_data2->remaining_socks;
				@endphp
				<tr >
					
					<td>{{$single_get_data2->style_code}}</td>
					<td>{{$single_get_data2->types_name}}</td>	
					<td>{{$single_get_data2->brand_name}}</td>	
					<td>{{$single_get_data2->brand_sizes}}</td>	
					<td>{{$single_get_data2->remaining_socks}} Pair</td>	
						
				</tr>

			@endforeach

			<tr>
				<td colspan="4">Total = </td>
				<td> {{$sum2}} Pair</td>
			</tr>

		</table>
	</div>
</div>
