<!DOCTYPE html>
<html>
<head>
    <title>VLL SOCKS</title>
    <link rel="stylesheet" href="{{ asset('public/backend/assets/css/bootstrap.min.css') }}">

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
        th {
		 font-size: 10px;
		}
    </style>
</head>
<body style="font-size: 13px">
   

<h2 style="text-align: center;"> DELIVERY CHALLAN </h2>

<p style="text-align: center;">Distributor: Venture LifeStyle Limited</p>
<p style="text-align: center;">Address:East Rampura, Titas Road, Dhaka-1219</p>
<p style="text-align: center;">Sales Contact : 01683-152823, 01710-495278</p>
 

<table>
    <tr>
        <td rowspan="4">
            To 
            <br>
            The Managing Director 
            <br>
            {{ $shop_info->client_name }} 
            <br>
            {{ $shop_info->address }}

           

        </td>
        <td>Delivery Challan No.</td>
        <td>{{$shop_info->challan_no}}</td>
    </tr>

    <tr>
        
        <td>Challan  Date</td>
        <td>{{date('Y-m-d')}}</td>
    </tr>

    <tr>
        
        <td>Purchase Order No.</td>
        <td>{{$shop_info->order_no}}</td>
    </tr>

    <tr>
       
        <td>P/O Date</td>
        <td>{{$shop_info->order_date}}</td>
    </tr>
</table>

<br><br><br>



<table>
    <tr>
        <td>SL</td>
        <th>PRODUCT NAME</th>                                                        
        <th>DESCRIPTION</th>
        <th>COLOR / DESIGN</th>
        <th>PER LOT QTY</th>
        <th>TOTAL QTY</th>
        <th>CPU</th>
        <th>COST AMOUNT</th>
    </tr>
@php
    $sl=1;
    $grand_total_qty=0;
    $grand_total_amt=0;
@endphp
@foreach($product_info as $single_info)

@php
    $grand_total_qty += $single_info->total_qty ;
    $grand_total_amt += $single_info->total_amt;
@endphp

<tr>
    <td>{{ $sl++ }}</td>
    <td>{{ $single_info->product_name }}</td>
    <td>{{ $single_info->types_name }}</td>
    <td>{{ $single_info->color_qty }}</td>
    <td>{{ $single_info->lot_qty }}</td>
    <td>{{ $single_info->total_qty }}</td>
    <td>{{ number_format($single_info->single_price, 2) }}</td>
    <td>{{ number_format($single_info->total_amt, 2) }}</td>
</tr>

@endforeach
    <tr>
        
        <th style="text-align: center" colspan="5">TOTAL</th>
        <th>{{ number_format($grand_total_qty, 2) }}</th>
        <th></th>
        <th>{{ number_format($grand_total_amt, 2) }}</th>
    </tr>
</table>
                  
 
 <br> <br>  <br>  


 <table style="border: none !important; ">
     <tr>
        <th style="border: none !important; text-align: center"> <h5>For Venture Lifestyle Ltd</h5> </th>
        <th style="border: none !important; text-align: center"> <h5>Received By</h5></th>
     </tr>

     <tr>
        <th style="border: none !important; text-align: center"> 
            <h5>{{ $shop_info->name }}</h5><br>
            <p>Sr. Marketing Manager</p> <br>
            <p>Contact No: +88 {{ $shop_info->mobile_number }}</p> 
        </th>
        <th style="border: none !important; text-align: center"> <h6> Authorized Signature & Company Stamp </h6></th>
     </tr>
 </table>

 {{-- <h5>Payment Instructions :</h5>
 <ul>
     <li>For Payments, kindly make crossed Cheque in favor of “Venture Solutions Ltd.” as “Venture Solutions Ltd.” is our Parent company. </li>
     <li>Mentioned price is excluding VAT & Tax.</li>
     <li>Please pay as per payment condition mentioned in Terms and Conditions of your Purchase Order under reference and feel free to contact if you have any query concerning payment & Invoice related issues.</li>
 </ul>
         
        
       
<div class="right" style="float: left;">

    ____________________________
    <p> Authorized Signature</p>
</div> --}} 
    
        






</body>
</html>

