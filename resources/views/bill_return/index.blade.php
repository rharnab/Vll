@extends('layouts.app')
@section('title','Bill Return')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/assets/css/notifications/toastr/toastr.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Bill</li>
            <li class="breadcrumb-item active"> Bill Return </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Bill Return Data
                                        </h2>

                                        <button class="btn btn-success btn-sm authorize_all">Bill Return</button>

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
                                                        <th>Agent Name </th>           
                                                        <th>Shops Name</th>
                                                        <th>Rack Code</th>
                                                        <th>Shocks Bill No</th>
                                                        <th>Billing Year Month</th>
                                                        <th>Total Sales Quantity</th>
                                                        <th>Total Collect Amount</th>
                                                        <th>Action</th>

                                                    </tr>


                                                </thead>
                                                <tbody>
                                                @php $sl=1; @endphp

                                                    @foreach($get_data as $single_data)

                                                    <tr>
                                                    
                                                        <td>{{$sl++}}</td>
                                                        <td>{{$single_data->agent_name}}</td>
                                                        <td>{{$single_data->shop_name}}</td>
                                                        <td>{{$single_data->rack_code}}</td>
                                                        <td>{{$single_data->shocks_bill_no}}</td>
                                                        <td>{{$single_data->billing_year_month}}</td>
                                                        <td>{{$single_data->total_sales_quantity}}</td>
                                                        <td>{{$single_data->total_collect_amt}}</td>

                                                        <td style="width:12%;">
                                                        <a   href="{{url('bill-return/show-details')}}/{{$single_data->shocks_bill_no}} " class="btn btn-warning btn-sm">Show Details</a>    
                                                        <!-- <a type="button" onclick="authorize_bill({{$single_data->id}})" class="btn btn-primary btn-sm ">Authorize</a> -->
                                                        </td>
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


    <script>

        function authorize_bill(value){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });


            cuteAlert({
                type: "question",
                title: "Do You Want To Authorize This !",
                message: "",
                confirmText: "Authorize",
                cancelText: "Cancel"
                }).then((e)=>{

                
                if ( e == ("confirm")){

                    var formData = {
                        socks_bill_id:value
                            
                        };

                            $.ajax({
                        type: 'POST',
                        url: "{{ url('bill-authorize/single-submit') }}",
                        data: formData,

                        beforeSend: function() {
                        jQuery(".loader").show();
                        },

                        success: function(data) {
                        
                            console.log(data);

                        
                            cuteAlert({
                            type: "success",
                            title: "Authorized Successful !",
                            message: "",
                            buttonText: "Okay"
                            }).then((e)=>{

                                location.reload(true);

                            });


                        },
                        error: function(response) {

                                
                                cuteAlert({
                            type: "warning",
                            title: "Authorized failed !",
                            message: "",
                            buttonText: "Okay",
                            timer: 10000
                            })

                        },

                        complete: function() {

                            jQuery(".loader").hide();
                        }

                    });


                } else {
                            cuteAlert({
                            type: "warning", // or 'info', 'error', 'warning'
                            title: "Cancel",
                            message: "",
                            timer: 10000
                            });
                }
            })

        } // normal authorize bill button 


        // multiple check box
        $(".authorize_all").hide();
        $(".checkbox_all").on("click", function(){
            
            var status=$(".checkbox_all").prop("checked");

            $(".checkbox_single").prop("checked", status);

            if (status==true) {

                    $(".authorize_all").show();
                
            }else{

                $(".authorize_all").hide();
            
            }

        });
        //end multiple check box

    // single check box
    $(".checkbox_single").on("click", function(){
 
        if ($('input.checkbox_single').is(':checked')) 
        {
            $(".authorize_all").show();

        }else{

            $(".authorize_all").hide();

        }


    });

// single check box
    </script>



@endpush
