@extends('layouts.app')
@section('title','Show Status Wise Report')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/assets/css/notifications/toastr/toastr.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active"> Area Wise Report </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2> Date Range  From {{ $starting_date }} To {{ $ending_date }}  </h2>

                                     

                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                            <!-- datatable start -->
                                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>No</th>
                                                        
                                                        <th>Brand Name</th>
                                                        <th>Types name</th>
                                                        <th>Size </th>
                                                        <th>Packet Code</th>
                                                        <th>Socks Code</th>
                                                        <th>Style Code</th>
                                                        <th>Bying Price</th>
                                                        <th>Single Price</th>
                                                        <th>Entry Date</th>
                                                        <th>Status</th>
                                                       
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                    $total_product = 0;
                                                    $total_buy_price = 0;
                                                    $total_sale_price = 0;
                                                    $total_due = 0;
                                                    $total_receive = 0;
                                                	@endphp
                                                	@foreach($product_info as $single_data)

                                                    @php 
                                                    $total_product += 1;
                                                    $total_buy_price += $single_data->buying_price;
                                                    $total_sale_price += $single_data->selling_price;
                                                   
                                                    if($single_data->status == 1 || $single_data->status == 3){
                                                        $total_due += $single_data->venture_amount;
                                                    }

                                                    if($single_data->status == 7){
                                                        $total_receive += $single_data->venture_amount;
                                                    }

                                                    @endphp


                                                	<tr>
                                                		
                                                			<td> {{ $sl++ }} </td>
                                                			<td> {{ $single_data->brand_name }}</td>
                                                			<td> {{ $single_data->types_name }}</td>
                                                			<td> {{ $single_data->size_name }}</td>
                                                		
                                                			<td> {{ $single_data->print_packet_code }}</td>
                                                			<td> {{ $single_data->printed_socks_code }}</td>
                                                			<td> {{ $single_data->style_code }}</td>
                                                            <td> {{ $single_data->buying_price }}</td>
                                                            <td> {{ $single_data->selling_price }}</td>
                                                            <td> {{ $single_data->entry_date }}</td>
                                                            <td>
                                                                @if($single_data->status =='0')
                                                                <span class="text-info">New</span>
                                                                @elseif($single_data->status =='1')
                                                                <span class="text-warning"> sold </span>
                                                                @elseif($single_data->status =='2')
                                                                <span class="text-info">Refill</span>
                                                                @elseif($single_data->status =='3')
                                                                <span class="text-danger">Agent Cash </span>
                                                                @elseif($single_data->status =='4')
                                                                <span class="text-info">Return </span>
                                                                @elseif($single_data->status =='7')
                                                                <span class="text-danger">Cash Receive </span>
                                                                @endif

                                                            </td>

                                                			

                                                	</tr>

                                                

                                                	@endforeach
                                                	
                                                	                                                   
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <th> Total Product</th>
                                                        <th>{{ $total_product }}</th>
                                                        <th>Total Buy Price</th>
                                                        <th>{{ number_format($total_buy_price, 2) }}</th>
                                                        <th>Total Sale Price </th>
                                                        <th>{{ number_format($total_sale_price, 2) }}</th>
                                                        <th>Total Bill Due</th>
                                                        <th>{{ number_format($total_due, 2)  }}</th>
                                                        <th>Total BIll Receive</th>
                                                        <th>{{ number_format($total_receive, 2) }}</th>
                                                        <th></th>
                                                        
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!-- datatable end -->
                                        </div>
                                    </div>
                                </div>

                <!-- data table -->
            </div>

        </div>


        




    </main>
@endsection

@push('js')

 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>
 <script src="{{ asset('public/backend/assets/js/notifications/toastr/toastr.js') }}"></script>

    <script>

    /*data table script*/

     $(document).ready(function()
            {

                // initialize datatable
                $('#dt-basic-example').dataTable(
                {
                    responsive: true,
                    lengthChange: false,
                    dom:
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        /*{
                            extend:    'colvis',
                            text:      'Column Visibility',
                            titleAttr: 'Col visibility',
                            className: 'mr-sm-3'
                        },*/
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            titleAttr: 'Generate PDF',
                            className: 'btn-outline-danger btn-sm mr-1'
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-success btn-sm mr-1'
                        },
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'copyHtml5',
                            text: 'Copy',
                            titleAttr: 'Copy to clipboard',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm'
                        }
                    ]
                });

            });

    /*data table script*/




        //tostr message 
         @if(Session::has('message'))
		  toastr.success("{{ session('message') }}");
		  @endif
    </script>




@endpush
