@extends('layouts.app')
@section('title','Report')

@push('css')
<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

<style>
    .table-hover tbody tr:hover {
        color: #212529;
        background-color: aquamarine;
    }
</style>

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active"> GL Transaction Report  </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                     <h2>GL Transaction Report  
                                         <strong class="ml-sm-2 text-info">
                                          [
                                             From Date {{ $from_date }} and   To Date {{ $to_date }}
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
                                           <table id="dt-basic-example" class="table table-sm table-bordered table-hover m-0">
                                                <thead class="bg-danger-600">
                                                    <tr class="text-uppercase">
                                                        <th>No </th>
                                                        <th>Date</th>
                                                        <th>Debit A/N</th>
                                                        <th>Debit A/C</th>
                                                        <th>Amount </th>
                                                        <th>Credit A/N</th>
                                                        <th>Credit A/C</th>
                                                        <th>Remarks </th>
                                                        <th>Authorize By</th>
                                                        <th>Authorize Date</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $sl=1 @endphp
                                                    @foreach($transactions as $transaction)
                                                        <tr>
                                                            <td>{{ $sl++ }}</td>
                                                            <td>{{ $transaction->transaction_date }}</td>
                                                            <td>{{ $transaction->dr_account_name }}</td>
                                                            <td>{{ $transaction->dr_acc_no }}</td>
                                                            @if($account_no == "all")
                                                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                                            @else 
                                                                @if($account_no == $transaction->dr_acc_no)
                                                                    <td style="font-weight: bold; color:red"> - {{ number_format($transaction->amount, 2) }}</td>
                                                                @else 
                                                                    <td style="font-weight: bold; color:green"> + {{ number_format($transaction->amount, 2) }}</td>
                                                                @endif
                                                            @endif
                                                            
                                                            <td>{{ $transaction->cr_account_name }}</td>
                                                            <td>{{ $transaction->cr_acc_no }}</td>
                                                            <td>{{ $transaction->remarks }}</td>
                                                            <td>{{ $transaction->authorized_user }} </td>
                                                            <td>{{ $transaction->authorized_at }}</td>
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