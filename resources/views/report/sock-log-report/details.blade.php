@extends('layouts.app')
@section('title','Bill Due Report')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active">  Single Socks Log Report </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                        Single Socks Log Report
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
                                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100">
                                                <thead class="bg-primary-600">

                                                    <tr>

                                                        <th>SL</th>
                                                        <th>Agent Name</th>
                                                       
                                                        <th>Shop Name</th>
                                                        <th>Rack No</th>
                                                        
                                                        <th>Type Name </th>
                                                        <th>Printed Socks Code</th>

                                                        <th>Status</th>
                                                        
                                                        <th>Message</th>
                                                        <th>Operation Date Time</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                	@endphp
                                                	
                                                   @foreach($get_data as $single_data)
                                                    <tr>
                                                        <td>{{$sl++}}</td>
                                                        <td>{{$single_data->agent_name}}</td>
                                                        <td>{{$single_data->shop_name}}</td>
                                                        
                                                        <td>{{$single_data->rack_code}}</td>
                                                       
                                                       
                                                        <td>{{$single_data->types_name}}</td>
                                                        <td>{{$single_data->printed_socks_code}}</td>
                                                        <td>
                                                            <?php 
                                                            $status = $single_data->status;

                                                            if($status == 0){
                                                                echo "RACK-FILL";
                                                            }elseif($status == 1){
                                                                echo "SHOPKEPPER SALES";
                                                            }elseif($status == 2){
                                                                echo "RACK-REFILL";
                                                            }elseif($status == 3){
                                                                echo "AGENT SALES";
                                                            }
                                                                echo '';
                                                            ?>
                                                        
                                                        </td>
                                                       
                                                        <td>{{$single_data->message}}</td>
                                                        <td>{{$single_data->operation_datetime}}</td>
                                                      
                                                     
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