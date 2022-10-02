@extends('layouts.app')
@section('title','Rack Current Socks')

@push('css')

    <link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active">  Rack Current Socks </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                           <span style="color:red;">{{$get_shop->name}} </span>  &nbsp; Type Wise Socks
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
                                                        <th>No</th>
                                                        <th>Type Name</th>
                                                        <th>Socks Pair</th>
                                                        <th>Total (TK)</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                    $sum_pair = $total_tk = 0;
                                                	@endphp
                                                	
                                                     
                                                        @foreach($get_data1 as $single_get_data)
                                                        @php
                                                            $sum_pair = $sum_pair + $single_get_data->pair;
                                                            $total_tk = $total_tk + $single_get_data->total;
                                                        @endphp

                                                        <tr> 
                                                            <td>{{ $sl++ }}</td>
                                                            <td>{{ $single_get_data->types_name }}</td>
                                                            <td>{{ $single_get_data->pair }}</td>
                                                            <td>{{ $single_get_data->total }}</td>
                                                        </tr>
                                                        @endforeach

                                                    
                                                	   <tr>
                                                           <td colspan="2">Total = </td>
                                                           <td>{{$sum_pair}} Pair</td>
                                                           <td>{{$total_tk}} TK</td>
                                                       </tr>                                                
                                                </tbody>
                                            </table>
                                            <!-- datatable end -->



                                            
                                        </div>
                                    </div>
                                </div>
                                

                <!-- data table -->
            </div>


            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                           <span style="color:red;">{{$get_shop->name}} </span>  &nbsp; Rack Current Socks
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
                                                        <th>No</th>
                                                        <th>Packet Code</th>
                                                        <th>Type</th>
                                                        <th>Socks Pair</th>
                                                        <th>Price (TK)</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                    $sum_pair = $total_tk = 0;
                                                	@endphp
                                                	
                                                     
                                                        @foreach($get_data2 as $single_get_data2)
                                                        @php
                                                            $sum_pair = $sum_pair + $single_get_data2->pair;
                                                            $total_tk = $total_tk + $single_get_data2->total;
                                                            
                                                        @endphp

                                                        <tr> 
                                                            <td>{{ $sl++ }}</td>
                                                            <td>
                                                                @if($single_get_data2->print_packet_code)

                                                                    {{$single_get_data2->print_packet_code}}

                                                                @else

                                                                    {{$single_get_data2->style_code}} 

                                                                @endif
                                                            </td>

                                                            <td>{{$single_get_data2->types_name}}</td>
                                                            <td>{{$single_get_data2->pair}}</td>
                                                            <td>{{$single_get_data2->total}}</td>
                                                           
                                                        </tr>
                                                        @endforeach

                                                    
                                                	   <tr>
                                                           <td colspan="3">Total = </td>
                                                           <td>{{$sum_pair}} Pair</td>
                                                           <td>{{$total_tk}} TK</td>
                                                       </tr>                                                
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