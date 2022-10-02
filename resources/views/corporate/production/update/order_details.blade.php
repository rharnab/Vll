<div class="panel-hdr">
    <h2 class="text-center"> Product list </h2>
</div>
<table class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
    <thead class="bg-primary-600">
        <tr>
            <td>SL</td>
            <th>PRODUCT NAME</th>                                                        
            <th>Size</th>
            <th>Quantity</th>
            <th>Unit Buy Price</th>
            <th>Unit Sale Price</th>
            <th>Total Buy Price</th>
            <th>Total Sale Price</th>
            <th>Option</th>
                                            
          
        </tr>
    </thead>
    <tbody>

        @php
        $sl=1;
        $grand_total_qty=0;
        $grand_total_buy_amt=0;
        $grand_total_sale_amt=0;
        @endphp
        @foreach($product_info as $single_info)
        
        @php
            $grand_total_qty += $single_info->total_qty ;
            $grand_total_buy_amt += $single_info->total_buy_amt;
            $grand_total_sale_amt += $single_info->total_sale_amt;
        @endphp

        <tr>
            <td>{{ $sl++ }}</td>
            <td>{{ $single_info->product_name }}</td>
            <td>{{ $single_info->types_name }}</td>
            <td>{{ $single_info->total_qty }}</td>
            <td>{{ number_format($single_info->unit_buy_price, 2) }}</td>
            <td>{{ number_format($single_info->unit_sale_price, 2) }}</td>
            <td>{{ number_format($single_info->total_buy_amt, 2) }}</td>
            <td>{{ number_format($single_info->total_sale_amt, 2) }}</td>
            <td><a target="_blank" class="btn btn-warning btn-sm" href="{{ route('corporate.Order.edit', Crypt::encrypt($single_info->sale_id)) }}">Edit</a></td>
        </tr>
        @endforeach
                                                            
    </tbody>
  
</table>
<!-- datatable end -->