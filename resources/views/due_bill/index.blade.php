@extends('layouts.app')
@section('title','Shops List')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/assets/css/notifications/toastr/toastr.css') }}">

 <style>
     .page-sidebar{
         display:none;
     }

     .hidden-md-down.dropdown-icon-menu.position-relative {
            display: none;
    }
 </style>
@endpush
@section('content')
<!-- BEGIN Page Content -->

        <div class="row">
            <div class="col-xl-6 col-md-6 col-sm-6">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                          Due Bill
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
                                                              
                                                        <th>Shops Name</th>
                                                        <th>Shops Address</th>

                                                        <th>Rack Code</th>
                                                        <th>Sold Date</th>
                                                        <th>Due Bill</th>

                        
                                                    </tr>


                                                </thead>
                                                <tbody>
                                                	

                                                     @php 

                                                        $sl=1;
                                                        $total_due = 0;

                                                     @endphp
                                                   
                                                     @foreach($get_data as $single_info)
                                                    
                                                        @php 
                                                        
                                                        
                                                        $total_due = $total_due + $single_info->due_bill;

                                                        @endphp

                                                    <tr>

                                                        <td>{{$sl++}}</td>   
                                                        <td>{{$single_info->NAME}}</td>   
                                                        <td>{{$single_info->shop_address}}</td>   
                                                        <td>{{$single_info->rack_code}}</td>   
                                                        <td>{{$single_info->sold_date}}</td>   
                                                        <td>{{$single_info->due_bill}}</td>   
                                                        
                                                    </tr>

                                                    @endforeach

                                                    <tr>
                                                        <th colspan="5" style="text-align:right;">Total Due =  </th>
                                                        <th>{{$total_due}}</th>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <!-- datatable end -->
                                        </div>
                                    </div>
                                </div>

                <!-- data table -->
            </div>


            
            <div class="col-xl-6 col-md-6 col-sm-6">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                          Refil
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
                                            <table id="dt-basic-example2" class="table table-bordered table-hover table-striped table-sm w-100">
                                                <thead class="bg-primary-600 text-uppercase">
                                                    <tr>

                                                        <th>#SL</th>
                                                        

                                                        <th>Shop Name</th>
                                                        <th>Shop Address</th>
                                                        <th>Rack Code</th>
                                                        <th>Remaining socks</th>
                                                      
                                                       
                                                        
                                                    
                                                    </tr>


                                                </thead>
                                                <tbody>
                                                	

                                                     @php $sl=1; @endphp

                                                     @foreach($refil_less_80 as $single_data)
                                                    <tr>
                                                        <td>{{$sl++}}</td>
                                                        <td>{{$single_data->NAME}}</td>
                                                        <td>{{$single_data->shop_address}}</td>
                                                        <td>{{$single_data->rack_code}}</td>
                                                        <td>{{$single_data->remaining_socks}}</td>
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
                    "pageLength": 50,
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

    
<script>

    /*data table script*/

     $(document).ready(function()
            {

                // initialize datatable
                $('#dt-basic-example2').dataTable(
                {
                    responsive: true,
                    lengthChange: false,
                    "pageLength": 50,
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




      
    </script>


@endpush
