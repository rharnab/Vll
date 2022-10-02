@extends('layouts.app')
@section('title','Corporate Bill Report')

@push('css')


<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item active">Corporate Bill Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Bill Details Report  [ <span class="font-weight-bold text-danger p-1">{{ $select_status }}</span> ] Date : [ <span class="text-danger m-2"> {{ $start_date }} TO {{ $end_date }} </span> ]</h2>
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
                                            <table  class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
                                                <thead class="bg-primary-600">
                                                    <tr class="text-uppercase">
                                                        <th>#SL</th>
                                                        <th>Client Name</th>
                                                        <th>Challan No</th>
                                                        <th>Order No</th>
                                                        <th>Total Quantity</th>
                                                        <th>Total Buy Price</th>
                                                        <th>Total Buy paid</th>
                                                        <th>Total Sale Price</th>
                                                        <th>Total Sale Paid</th>
                                                    </tr>


                                                </thead>

                                                <tbody>
                                                    @php
                                                        $sl=1; $grand_product=0; $grand_buy_amt=0; $grand_buy_paid_amt=0; 
                                                        $grand_sale_amt = 0; $grand_sale_paid_amt=0;
                                                    @endphp

                                                    @foreach($details_info as $single_result)
                                                    @php
                                                        $grand_product += $single_result->total_qty;
                                                        $grand_buy_amt += $single_result->total_buy_amt;
                                                        $grand_buy_paid_amt += $single_result->total_buy_paid_amt;
                                                        $grand_sale_amt += $single_result->total_sale_amt;
                                                        $grand_sale_paid_amt += $single_result->total_sale_paid_amt;
                                                    @endphp





                                                    <tr>

                                                        <td>{{ $sl++ }}</td>
                                                        <td>{{  $single_result->client_name }}</td>
                                                        <td>{{  $single_result->challan_no }}</td>
                                                        <td>{{  $single_result->order_no }}</td>
                                                        <td>{{  $single_result->total_qty }}</td>
                                                        <td>{{ number_format($single_result->total_buy_amt, 2) }}</td>
                                                        <td>{{ number_format($single_result->total_buy_paid_amt, 2) }}</td>
                                                        <td>{{ number_format($single_result->total_sale_amt, 2) }}</td>
                                                        <td>{{ number_format($single_result->total_sale_paid_amt, 2) }}</td>
                                                       
                                                    </tr>
                                                    @endforeach

                                                    
                                                                                          
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                      <th colspan="4">Total</th>
                                                      <th>{{ $grand_product }}</th>
                                                      <th>{{ number_format($grand_buy_amt, 2) }}</th>
                                                      <th>{{ number_format($grand_buy_paid_amt, 2) }}</th>
                                                      <th>{{ number_format($grand_sale_amt, 2) }}</th>
                                                      <th>{{ number_format($grand_sale_paid_amt, 2) }}</th>
                                                   
                                                      
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
