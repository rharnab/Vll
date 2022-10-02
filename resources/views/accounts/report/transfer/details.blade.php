@extends('layouts.app')
@section('title','Report')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active"> Balance Transfer Report  </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                     <h2>Balance Transfer  Report  
                                         <strong class="ml-sm-2 text-info">
                                          [
                                             From Date {{ $frm_date }} and   To Date {{ $to_date }}
                                          ]
                                        </strong> 
                                    </h2>

                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                           <!-- datatable start -->
                                           <table id="dt-basic-example" class="table table-bordered table-hover m-0">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>No </th>
                                                        <th>From Account </th>
                                                        <th>To Account </th>
                                                        <th>Amount </th>
                                                        <th>Cheque Number </th>
                                                        <th>Remarks </th>
                                                        <th>transaction Date</th>
                                                        <th>Authorize By</th>
                                                        <th>Authorize Date</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                	@endphp
                                                    
                                                	@foreach($transaction_result as $single_data)
                                                    
                                                    @php

                                                    $cr_info= explode('-', $single_data->cr_transaction_info); 

                                                    @endphp

                                                	<tr>

                                                		<td>{{ $sl++ }}</td>
                                                		<td>{{ $single_data->dr_ac }}</td>
                                                        
                                                        <td>{{ $cr_info[1] }} </td>

                                                       
                                                        <td>{{ str_replace('-','', $single_data->dr_amount) }}</td>
                                                        <td>
                                                           @if($single_data->instrument_no > 0)
                                                           {{ $single_data->instrument_no }}
                                                           @else
                                                           -
                                                           @endif
                                                        </td>
                                                        <td>{{ $single_data->remarks}}</td>
                                                        <td>{{ $single_data->dr_trn_date}}</td>
                                                        <td>{{ $single_data->auth_by}}</td>
                                                        <td>{{ $single_data->authorized_at}}</td>
                                                        


                                                	</tr>

                                                	@endforeach
                                                	
                                                	                                                   
                                                </tbody>
                                            </table>
                                            <!-- datatable end -->

                                            <table class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                                                <tr>
                                               
                                                   
                                                    @foreach($summation_result as $single_result )
                                                    <th width="10%"></th>
                                                       
                                                      
                                                       <th width="10%"></th>
                                                       <th width="10%" colspan="2"> Total </th>
                                                       
                                                       <th width="10%"> {{ $single_result->total_amount  }}</th>
                                                       <th width="10%"> </th>
                                                       <th width="10%"></th>
                                                       <th width="10%"></th>
                                                       <th width="10%"></th>
                                                       <th width="10%"></th>
                                                       <th width="10%"></th>
                                                      

                                                     @endforeach

                                                   
                                                   
                                                </tr>
                                            </table>
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
    </script>




@endpush