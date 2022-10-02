<!DOCTYPE html>
<html>
<head>
    <title>VLL SOCKS</title>

    <style type="text/css">
        table, td, th {  
		  border: 1px solid black;
		  text-align: left;
		}

		table {
		  border-collapse: collapse;
		  width: 100%;
		}

		th, td {
		  padding: 15px;
		}
    </style>
</head>
<body>
   

<h2 style="text-align: center;">VLL SOCKS</h2>

<p style="text-align: center;">Distributor: Sure Success Limited</p>
<p style="text-align: center;">Address:East Rampura, Titas Road, Dhaka-1219</p>
<p style="text-align: center;">Sales Contact : 01683-152823, 01710-495278</p>
 

<hr>

<div class="left" style="float: left;">

  
    <p style="text-align:center;">Client Name :  </p>
</div>            
        
       
<div class="right" style="float: right;">

  
    <p>Memo No: {{ $voucher_no }}</p>

</div> 


<br><br><br>


<div class="left" style="float: left;">

  
    <p style="text-align:center;">Client Address : </p>
</div>            
        
       
<div class="right" style="float: right;">

  
    <p>Date :  </p>

</div> 


<br><br><br><br><br>

<table>
    <tr>
        <th>SL</th>
        <th>Brand </th>                                                        
        <th>Type</th>
        <th>Brand Size</th>
        <th>Unit</th>
        <th>Amount</th>
    </tr>
@php 
	$total = 0;
@endphp
@foreach($shcoks_datas as $shocks)

@php $total += $shocks->total_amount; @endphp 

    <tr>
        <td>{{ $sl++ }}</td>
        <td>{{ $shocks->brand_name }}</td>
        <td>{{ $shocks->type_name }}</td>
        <td>{{ $shocks->brand_size }}</td>
        <td>{{ $shocks->total_socks }} Pair</td>
        <td>{{ number_format($shocks->total_amount,2) }}</td>
    </tr>
@endforeach



    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>TOTAL AMOUNT</td>
        <td>{{ number_format($total,2) }}</td>
    </tr>

     <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>PAID AMOUNT</td>
        <td>-</td>
    </tr>

     <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>DUE AMOUNT</td>
        <td>-</td>
    </tr>

</table>
                  
 
 <br> <br>  <br>  

<div class="left" style="float: left;">

    __________________________
    <p style="text-align:center;">CUSTOMER SIGNATURE</p>
</div>            
        
       
<div class="right" style="float: right;">

    ____________________________
    <p>SALES OFFICER SIGNATURE</p>
</div> 
    
        






</body>
</html>

