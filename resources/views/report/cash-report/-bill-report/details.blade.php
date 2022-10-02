@extends('layouts.app')
@section('title','Bill Summary Report')

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
            <li class="breadcrumb-item active">Bill Summary Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        @php
                        if(isset($agent_info->name ) ){
                            $agent_name  = $agent_info->name;
                        }else{
                            $agent_name  = '';
                        }
                        
                        @endphp
                        <h2>Bill Summary Report  [ <span class="font-weight-bold text-danger p-1">{{ $status_type }}</span> ] Date : [ <span class="text-danger m-2"> {{ $frm_date }} TO {{ $to_date }} </span> ] Agent Name : [ <span class="text-danger m-2">{{ $agent_name }}</span> ] Shop Name : [ <span class="text-danger m-2">{{ $shop_name }}</span> ]</h2>
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
                                                        <th>Shop Name</th>
                                                        <th>Total Shocks</th>
                                                        <th>Total Bill</th>
                                                        <th>Shop Commission</th>
                                                        <th>Agent Commission</th>
                                                        <th>venture  Amount</th>
                                                        <th>Total Profit</th>
                                                        <th>Details</th>
                                                    </tr>


                                                </thead>

                                                <tbody>
                                                    @php
                                                        $sl=1;
                                                    @endphp

                                                    @foreach($bill_result as $single_result)
                                                    <tr>

                                                        <td>{{ $sl++ }}</td>
                                                        <td>{{ date('M-Y', strtotime($single_result->sold_date)) }}</td>
                                                        <td>{{ $single_result->total_socks }}</td>
                                                        <td>{{ number_format($single_result->total_bill, 2) }}</td>
                                                        <td>{{ number_format($single_result->shop_commission_amt, 2) }}</td>
                                                        <td>{{ number_format($single_result->agent_commission_amt, 2) }}</td>
                                                        <td>{{ number_format($single_result->venture_commission_amt, 2) }}</td>
                                                        <td>{{ number_format($single_result->total_profit_amount, 2) }}</td>
                                                        {{-- <td><button class="btn btn-primary btn-sm" onclick=RackBillDetails('{{ $single_result->sold_date }}') >Details</button></td> --}}
                                                        <td>

                                                            @php
                                                                if(isset($agent_info->id ) ){
                                                                    $agent_id  = $agent_info->id;
                                                                }else{
                                                                    $agent_id  = '';
                                                                }
                                                                
                                                                
                                                            @endphp
                                                            <form method="post" action="{{ route('report.cash_report.rack_details') }}" target="_blank">
                                                                @csrf
                                                                <input type="hidden" id="rack_status" name="rack_status" value="{{ $status }}">
                                                                <input type="hidden" id="sold_date" name="sold_date" value="{{ $single_result->sold_date }}">
                                                                <input type="hidden" id="agent_id" name="agent_id" value="{{ $agent_id}}">
                                                                <input type="hidden" id="shop_id" name="shop_id" value="{{ $shop_id}}">
                                                                <input type="hidden" id="frm_date" name="frm_date" value="{{ $frm_date}}">
                                                                <input type="hidden" id="to_date" name="to_date" value="{{ $to_date}}">
                                                                <button class="btn btn-primary btn-sm" type="submit" >Details</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                    
                                                                                          
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                       <th colspan="2">Total</th>
                                                   
                                                      
                                                       <th>{{ $sum_result[0]->grand_total_socks }}</th>
                                                       <th>{{ number_format($sum_result[0]->grand_total_bill, 2) }}</th>
                                                       <th>{{ number_format($sum_result[0]->grand_total_shop_commission, 2) }}</th>
                                                       <th>{{ number_format($sum_result[0]->grand_total_agent_commission, 2) }}</th>
                                                       <th>{{ number_format($sum_result[0]->grand_total_venture_amount, 2) }}</th>
                                                       <th>{{ number_format($sum_result[0]->grand_total_profit_amount, 2) }}</th>
                                                       
                                                        
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
