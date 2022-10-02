@extends('layouts.app')
@section('title','Corporate  Sale')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item active"> Corporate  Sale Authorize </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                      
                                       
                                       <h2> Corporate  Sale Authorize  </h2>
                                       
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                            <!-- datatable start -->
                                            <table class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                       <th>#Sl</th>
                                                       <th>Client Name</th>
                                                       <th>Chalan No</th>
                                                       <th>Order No</th>
                                                       <th>Total Product</th>
                                                       <th>Total Bill </th>
                                                       <th>Total Due </th>
                                                       <th>Status </th>
                                                       <th>Option </th>

                                                    
                                                       
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                	@endphp

                                                    @foreach($all_order as $single_data)
                                                    <tr>
                                                        <td>{{ $sl++ }}</td>
                                                        <td>{{ $single_data->client_name }}</td>
                                                        <td>{{ $single_data->challan_no }}</td>
                                                        <td>{{ $single_data->order_no }}</td>
                                                        <td>{{ $single_data->total_product }}</td>
                                                        <td>{{ number_format($single_data->total_bill, 2) }}</td>
                                                        <td>{{ number_format($single_data->total_due, 2) }}</td>
                                                        @php
                                                            switch ($single_data->status) {
                                                                case 1:
                                                                     $sts= "Pending";
                                                                    break;
                                                                case 2:
                                                                     $sts= "Production";
                                                                    break;
                                                                
                                                                case 3:
                                                                     $sts= "Delivery";
                                                                    break;
                                                                case 4:
                                                                     $sts= "Partial Payment";
                                                                    break;
                                                                case 5:
                                                                     $sts= "Full Payment";
                                                                    break;
                                                                default:
                                                                   $sts = "Not found";
                                                                    break;
                                                            }

                                                            
                                                        @endphp
                                                        <td>@if($single_data->status == '1')
                                                                {{'Initial'}}
                                                            @elseif($single_data->status == '2')
                                                                {{'Production'}}
                                                            @elseif($single_data->status == '3')
                                                                {{'Delivery'}}
                                                            @elseif($single_data->status == '4')
                                                                {{'Partial Payment'}}  

                                                            @endif  </td>
                                                        <td>
                                                            <a   href="{{ route('corporate.Order.show_voucher',Crypt::encrypt($single_data->challan_no)) }}" class="btn btn-warning btn-sm">Show Details</a>    
                                                            
                                                            </td>
                                                    </tr>

                                                    @endforeach
                                                                                                                                                            
                                                </tbody>
                                              
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

<script>
    /*data table script*/

     $(document).ready(function()
            {
                dataTableWithBUtton();

            });
    </script>

    <script>
        function dataTableWithBUtton()
        {

            
               // initialize datatable
               $('.dataTable').dataTable(
                {
                    responsive: true,
                    "pageLength": 50,

                      dom:
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        
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
                       
                        
                        
                    ]

                });

        }
    </script>



@endpush