@extends('layouts.app')
@section('title','Bill Details Report')

@push('css')


<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item ">Bill Report</li>
            <li class="breadcrumb-item active">Bill Details Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        
                        @if(date('m') == date('m', strtotime($report_date)))
                                       
                        <h2>This month Bill Details Report </h2>
                        @else
                        <h2>Last month Bill Details Report </h2>
                        @endif

                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                            </div>
                        </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                       
                                            <!-- datatable start  for sold-->
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
                                                        {{-- <th>Profit  Amount</th> --}}
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                $sl=1;
                                                @endphp
                                                 @foreach($socks_bill as $single_result)
                                                 <tr>
                                        
                                                     <td>{{ $sl++ }}</td>
                                                     <td>{{ $single_result->shop_name }}</td>
                                                     <td>{{ date('M-Y', strtotime($single_result->sold_date)) }}</td>
                                                     <td>{{ $single_result->total_socks }}</td>
                                                     <td>{{ number_format($single_result->total_bill, 2) }}</td>
                                                     <td>{{ number_format($single_result->shop_commission_amt, 2) }}</td>
                                                     <td>{{ number_format($single_result->agent_commission_amt, 2) }}</td>
                                                     <td>{{ number_format($single_result->venture_commission_amt, 2) }}</td>
                                                     {{-- <td>{{ number_format($single_result->total_profit_amount, 2) }}</td> --}}
                                                    
                                                 </tr>
                                                 @endforeach
                                                                                                       
                                                </tbody>
                                                <tfoot>
                                                   
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>{{ $summation_reuslt->grand_shocks }}</td>
                                                        <td>{{ number_format($summation_reuslt->grand_total_bill, 2) }}</td>
                                                        <td>{{ number_format($summation_reuslt->grand_shop_commission, 2) }}</td>
                                                        <td>{{ number_format($summation_reuslt->grand_agent_commission, 2) }}</td>
                                                        <td>{{ number_format($summation_reuslt->grand_venture_amt, 2) }}</td>
                                                        
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                
                         
                                </div>


                              

                        </div>
                    </div>
                </div>
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
