     
     <div class="panel-hdr">
        <h2>Bill Details Report  [ <span class="font-weight-bold text-danger p-1">{{ date('M-Y', strtotime($sold_date)) }}</span> ] </h2>
    </div>
     <table  class="table table-bordered  table-hover table-striped table-sm w-100 text-center dataTable">
        <thead class="bg-primary-600">
            <tr>
                <th>#SL</th>
                <th>Shop Name</th>
                <th>Bill Month</th>
                <th>Total Shocks</th>
                <th>Total Bill</th>
                <th>Shop Commission</th>
                <th>Agent Commission</th>
                <th>venture  Amount</th>
                <th>Profit  Amount</th>
                
            </tr>
        </thead>
        <tbody>
            @php
        $sl=1;
        @endphp
         @foreach($rack_Bill_details as $single_result)
         <tr>

             <td>{{ $sl++ }}</td>
             <td>{{ $single_result->shop_name }}</td>
             <td>{{ date('M-Y', strtotime($single_result->sold_date)) }}</td>
             <td>{{ $single_result->total_socks }}</td>
             <td>{{ number_format($single_result->total_bill, 2) }}</td>
             <td>{{ number_format($single_result->shop_commission_amt, 2) }}</td>
             <td>{{ number_format($single_result->agent_commission_amt, 2) }}</td>
             <td>{{ number_format($single_result->venture_commission_amt, 2) }}</td>
             <td>{{ number_format($single_result->total_profit_amount, 2) }}</td>
            
         </tr>
         @endforeach
                                                               
        </tbody>
    </table>

    
   