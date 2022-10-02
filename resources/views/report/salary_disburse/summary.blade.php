@extends('layouts.app')
@section('title','Salary Disburse Report')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active"> Salary Disburse Report </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                     <h2> Shop Report </h2>

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
                                                       <th>Employee Name</th>
                                                       <th>Mobile Number</th>
                                                       <th>Total Month</th>
                                                       <th>Total Paid Salary</th>
                                                       <th>Option</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1; $total_sum = 0;
                                                   
                                                	@endphp
                                                    @foreach($summary_info as $single_result)
                                                    @php $total_sum += $single_result->total_salary  @endphp
                                                    @php @endphp
                                                    <tr>
                                                        <td>{{ $sl++ }}</td>
                                                        <td>{{ $single_result->name }}</td>
                                                        <td>{{ $single_result->mobile_no }}</td>
                                                        <td>{{ $single_result->total_salary_month }}</td>
                                                        <td>{{ number_format($single_result->total_salary, 2) }}</td>
                                                        <td><a target="_blank" class="form-control btn btn-primary btn-sm" href="{{ route('report.salary.disburse.details', [Crypt::encrypt($single_result->employee_id), $frm_date, $to_date] ) }}">Details</a></td>
                                                    </tr>
                                                    @endforeach
                                                	
                                                    <footer>
                                                        <tr>
                                                            <th colspan="4">Total</th>
                                                            <th>{{ number_format($total_sum, 2) }}</th>
                                                            <th></th>
                                                        </tr>
                                                    </footer>
                                                	                                                   
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