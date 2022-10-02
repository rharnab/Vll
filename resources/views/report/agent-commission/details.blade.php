@extends('layouts.app')
@section('title','Agent Report')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active"> Agent Commission Report </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                     <h2> Agent Commission Report  Date : [ <span class="text-danger m-2"> {{ $frm_date }} TO {{ $to_date }} </span> ] Agent Name : [ <span class="text-danger m-2">{{ $agent_name }}</span> ] Shop Name : [ <span class="text-danger m-2">{{ $shop_name }}</span> ]</h2>

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
                                                       <th>Shop Name</th>
                                                       <th>Rack Code</th>
                                                       <th>Sold Socks</th>
                                                       <th>Sale Price</th>
                                                       <th>Shop Amount </th>
                                                       <th>Agent Amount</th>
                                                       <th>Venture Amount</th>
                                                       <th>Paid Agent Amt</th>
                                                       <th>Paid convience Amount</th>
                                                       <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                	@endphp
                                                    @foreach($result as $single_result)
                                                    <tr>
                                                        <td>{{ $sl++ }}</td>
                                                        <td>{{ $single_result->shop_name }}</td>
                                                        <td>{{ $single_result->rack_code }}</td>
                                                        <td>{{ $single_result->total_sold_socks }}</td>
                                                        <td>{{ number_format($single_result->total_sale_price, 2) }}</td>
                                                        <td>{{ number_format($single_result->total_shop_commission, 2) }}</td>
                                                        <td>{{ number_format($single_result->total_agent_commission, 2) }}</td>
                                                        <td>{{ number_format($single_result->total_venture_amt, 2) }}</td>
                                                        <td>{{ number_format($single_result->paid_agent_commission, 2) }}</td>
                                                        <td>{{ number_format($single_result->paid_convenience, 2) }}</td>
                                                         @php 
                                                         $url_array =[
                                                                    'rack_code' => $single_result->rack_code,
                                                                    'frm_date'=> $frm_date,
                                                                    'to_date' => $to_date
                                                            ];
                                                         
                                                         @endphp
                                                        <td><a href="{{ route('report.agent.commission.shop_details', Crypt::encrypt($url_array)) }}" target="_blank">Details</a></td>
                                                        
                                                    </tr>
                                                    @endforeach 	                                                 
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">Total</td>
                                                        
                                                        <td>{{ $grand_total[0]->grand_sold_socks }}</td>
                                                        <td>{{ number_format($grand_total[0]->grand_sale_price, 2) }}</td>
                                                        <td>{{ number_format($grand_total[0]->grand_shop_commission, 2) }}</td>
                                                        <td>{{ number_format($grand_total[0]->grand_agent_commission, 2) }}</td>
                                                        <td>{{ number_format($grand_total[0]->grand_venture_amt, 2) }}</td>
                                                        <td>{{ number_format($grand_total[0]->grand_paid_agent_commission, 2) }}</td>
                                                        <td>{{ number_format($grand_total[0]->grand_paid_convenience, 2) }}</td>
                                                        <td></td>
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