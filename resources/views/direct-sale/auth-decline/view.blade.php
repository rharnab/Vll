@extends('layouts.app')
@section('title','Rack-Fillup')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Single Sale</li>
            <li class="breadcrumb-item active"> Single Sale </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                           Voucher {{ $voucher_no }} Details
                                        </h2>

                                        <span style="float:left" class="pr-4">
                                            @if($voucher_link === false)
                                                <button class="btn btn-sm btn-danger"  onclick="declineVoucher({{ $voucher_no }})">
                                                    Decline
                                                </button> || 
                                                <button class="btn btn-sm btn-success" onclick="authorizeVoucher({{ $voucher_no }})">
                                                    Authorization
                                                </button>
                                            @else 
                                                <a href="{{ route('direct_sale.auth_decline.voucher_download', [$voucher_no]) }}"  class="btn btn-sm btn-success">Voucher Download</a>
                                            @endif
                                          
                                        </span>

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
                                                        <th>#SL</th>
                                                        <th>Packet Code</th>
                                                        <th>Brand </th>                                                        
                                                        <th>Type</th>
                                                        <th>Brand Size</th>
                                                        <th>Socks pair</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	@foreach($socks as $sock)
                                                        <tr>
                                                            <td>{{  $sl++  }}</td>
                                                            <td>{{ $sock->packet_code }}</td>
                                                            <td>{{ $sock->brand_name }}</td>
                                                            <td>{{ $sock->type_name }}</td>
                                                            <td>{{ $sock->brand_size }}</td>
                                                            <td>{{ $sock->total_socks }} Pair</td>
                                                            <td>{{ number_format($sock->total_amount,2) }}</td>                                                            
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


        
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="voucher_authorize_route" value="{{ route('direct_sale.auth_decline.voucher_authorize') }}">
        <input type="hidden" id="voucher_decline_route" value="{{ route('direct_sale.auth_decline.voucher_decline') }}">






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


    <script>
        function authorizeVoucher(voucher_no){
            var voucher_authorize_route = $("#voucher_authorize_route").val();
            var _token                  = $("#_token").val();
            cuteAlert({
                type       : "question",
                title      : "Confirmation",
                message    : "Are your sure ? You want to authorize this voucher",
                confirmText: "Yes",
                cancelText : "No"
            }).then((e)=>{
                if (e == ("confirm")){
                    $.ajax({
                        type: 'POST',
                        url : voucher_authorize_route,
                        data: {
                            "_token"    : _token,
                            "voucher_no": voucher_no
                        },
                        beforeSend: function() {
                            loaderStart();
                        },
                        success: (data) => {
                            if(data.status === 200){
                                cuteAlert({
                                    type      : "success",
                                    title     : "Success",
                                    message   : data.message,
                                    buttonText: "ok"
                                }).then((e)=>{
                                    location.reload(true);
                                });
                            }else{
                                cuteAlert({
                                    type: "error",
                                    title: "Error",
                                    message: data.message,
                                    buttonText: "Try Again"
                                });                                 
                            }  
                        },
                        error: function(data) {
                           
                        },
                        complete: function() {
                            loaderEnd();
                        }
                    });
                }
            })
        }
    </script>


    <script>
        function declineVoucher(voucher_no){
            var voucher_decline_route = $("#voucher_decline_route").val();
            var _token                  = $("#_token").val();
            cuteAlert({
                type       : "question",
                title      : "Confirmation",
                message    : "Are your sure ? You want to decline this voucher",
                confirmText: "Yes",
                cancelText : "No"
            }).then((e)=>{
                if (e == ("confirm")){
                    $.ajax({
                        type: 'POST',
                        url : voucher_decline_route,
                        data: {
                            "_token"    : _token,
                            "voucher_no": voucher_no
                        },
                        beforeSend: function() {
                            loaderStart();
                        },
                        success: (data) => {
                            if(data.status === 200){
                                cuteAlert({
                                    type      : "success",
                                    title     : "Success",
                                    message   : data.message,
                                    buttonText: "ok"
                                }).then((e)=>{
                                    location.reload(true);
                                });
                            }else{
                                cuteAlert({
                                    type: "error",
                                    title: "Error",
                                    message: data.message,
                                    buttonText: "Try Again"
                                });                                 
                            }  
                        },
                        error: function(data) {
                           
                        },
                        complete: function() {
                            loaderEnd();
                        }
                    });
                }
            })
        }
    </script>



@endpush
