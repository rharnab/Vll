@extends('layouts.app')
@section('title','Show Status Wise Report')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/assets/css/notifications/toastr/toastr.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active"> Show Status Wise Report </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>Status Wise Report</h2>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                            <!-- datatable start -->
                                            <table class="table table-bordered table-hover table-striped table-sm w-100">
                                                <tr>
                                                    <th>Shop Name</th>
                                                    <td>
                                                        @if(!empty($get_report_data_single[0]->shop_name))

                                                        {{ $get_report_data_single[0]->shop_name}}
        
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Agent Name</th>
                                                    <td>
                                                    @if(!empty($get_report_data_single[0]->agent_name))

                                                        {{ $get_report_data_single[0]->agent_name}}

                                                    @endif
    
                                                  </td>
                                                </tr>

                                                <tr>
                                                    <th>Rack Code</th>
                                                    <td>
                                                    @if(!empty($get_report_data_single[0]->rack_code))

                                                    {{ $get_report_data_single[0]->rack_code}}

                                                    @endif

                                                   </td>
                                                </tr>

                                            </table>
                                            <!-- datatable end -->
                                        </div>
                                    </div>
                                </div>

                <!-- data table -->
            </div>

        </div>


        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                        <span class="text-danger">{{$show_status}} </span> &nbsp; Report
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
                                                <thead class="bg-primary-600 text-uppercase">
                                                    <tr>

                                                        <th>#SL</th>
                                                        <th>Packet Code</th>           
                                                        <th>Types</th>           
                                                        <th>Socks Code</th>
                                                        <th>Buying Price</th>
                                                        <th>Selling Price</th>
                                                        <th>entry_date</th>
                                                    
                                                    </tr>


                                                </thead>
                                                <tbody>
                                                	

                                                     @php $sl=1; @endphp

                                                    @foreach($get_report_data as $single_report_data)
                                                    <tr>
                                                        <td>{{$sl++}}</td>
                                                        <td>{{$single_report_data->packet_code}}</td>
                                                        <td>{{$single_report_data->types_name}}</td>
                                                        <td>
                                                            @if(!empty($single_report_data->printed_socks_code))
                                                                {{$single_report_data->printed_socks_code}}
                                                            @else
                                                                {{$single_report_data->shocks_code}}
                                                            @endif
                                                        </td>


                                                        <td>{{$single_report_data->buying_price}}</td>
                                                        <td>{{$single_report_data->selling_price}}</td>
                                                        <td>{{$single_report_data->entry_date}}</td>

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
 <script src="{{ asset('public/backend/assets/js/notifications/toastr/toastr.js') }}"></script>

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

    /*data table script*/




        //tostr message 
         @if(Session::has('message'))
		  toastr.success("{{ session('message') }}");
		  @endif
    </script>




@endpush
