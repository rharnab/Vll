@extends('layouts.app')
@section('title','Status wise summation report')

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
            <li class="breadcrumb-item active"> Show Status Wise Summation Report </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



<<<<<<< HEAD
=======

>>>>>>> f5637a8a2e693190d55ebcb37c9bb60af5a77d00
        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>From [ {{ $starting_date }} ]  To   [ {{ $ending_date }} ]</h2>

                                     

                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                            <!-- datatable start -->
                                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                                                <thead class="bg-primary-600 text-uppercase ">

                                                  
                                                    <tr>
<<<<<<< HEAD
                                                        <th colspan="3"></th>

                                                        @foreach($status_array as $val)
                                                        <th colspan="3">{{  $val }}</th>
=======
                                                        <th colspan="4"></th>

                                                        @foreach($status_array as $val)
                                                        <th colspan="4">{{  $val }}</th>
>>>>>>> f5637a8a2e693190d55ebcb37c9bb60af5a77d00
                                                        @endforeach                                                    
                                                    </tr>

                                                    <tr>
                                                        <th>#SL</th>
                                                        <th>Shop Name</th>           
                                                        <th>Rack Code</th>
                                                        @foreach($status_array as $val)
                                                        <th>Total Product</th>
                                                        <th>Total Buy Price</th>                                                    
                                                        <th>Total Sell Price</th> 
<<<<<<< HEAD
=======
                                                        <th>total Venture amount</th> 
>>>>>>> f5637a8a2e693190d55ebcb37c9bb60af5a77d00
                                                        @endforeach 
                                                        
                                                    </tr>

                                                   


                                                </thead>
                                                <tbody>
                                                	
                                                @php 
                                                    $sl=1; 
                                                    $total_product = 0;
                                                    $total_buy = 0;
                                                    $total_sell = 0;
                                                @endphp

                                                @foreach($shop_rack_info as $data)

                                                    @php 
                                                       /*  $total_product += $data->total_product;
                                                        $total_buy += $data->total_buy_price;
                                                        $total_sell += $data->total_sell_price; */
                                                    @endphp
                                                    <tr>
                                                        <td>{{$sl++}}</td>
                                                        <td>{{$data->shop_name}}</td>
                                                        <td>{{$data->rack_code}}</td>
                                                        @foreach($status_array as $val)
                                                            @if(!empty($all_result[$data->rack_code][$val]))
                                                        <td>{{ $all_result[$data->rack_code][$val][0]->total_product }}</td>
                                                        <td>{{ number_format($all_result[$data->rack_code][$val][0]->total_buy_price, 2) }}</td>
                                                        <td>{{ number_format($all_result[$data->rack_code][$val][0]->total_sell_price, 2) }}</td>
<<<<<<< HEAD
=======
                                                        <td>{{ number_format($all_result[$data->rack_code][$val][0]->total_venture_amt, 2) }}</td>
>>>>>>> f5637a8a2e693190d55ebcb37c9bb60af5a77d00
                                                            @else
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
<<<<<<< HEAD
=======
                                                                <td>0</td>
>>>>>>> f5637a8a2e693190d55ebcb37c9bb60af5a77d00
                                                          
                                                            @endif
                                                        @endforeach
                                                       

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
                    lengthChange: true,
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
