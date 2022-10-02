@extends('layouts.app')
@section('title','Shops List')

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
            <li class="breadcrumb-item active"> Bill return details </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-8">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                    Bill return details   {{$get_data_shocks_bill->voucher_link}}
                            </h2>

                            <button class="btn btn-success btn-sm authorize_all">Authorize All</button>

                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                            </div>
                        </div>

                        <div class="panel-container show">
                            <div class="panel-content">
                               
                            <iframe style="display: block;" src="{{ asset('public/'.$get_data_shocks_bill->voucher_link)}}" width="100%"  height="800px"></iframe>
                                
                            </div>
                        </div>
                    </div>

                <!-- data table -->
            </div>

            <div class="col-xl-4 col-md-4 col-sm-4">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                         <h2> Bill return details </h2>
                    </div>

                    <div class="panel-container show">
                            <div class="panel-content">
                            <form action="" method="post">
                                @csrf
                                <input type="hidden" name="total_month" id="total_month" value="{{$get_single_commission_data->total_month}}">
                                <table class="table table-bordered">

                                    <tr>
                                       
                                       <td colspan="2">
                                           <b>Conveynce Month : </b> 
                                           
                                            <span name="conveynce_month" id="conveynce_month">{{$billing_month}}</span>
                                        </td>
                                   </tr>

                                   <tr>
                                       <td colspan="2">
                                        <b>Bill No : </b>
                                        <span  id="bill_no" >{{$get_single_commission_data->shoks_bill_no}}</span>
                                       
                                       </td>
                                   </tr>
                                   
                                   <tr>
                                    <td colspan="2">
                                     <b>Total Bill : </b>
                                     <span  >{{ number_format($get_single_commission_data->total_bill, 2) }}</span>
                                     <input type="hidden" id="total_bill" value="{{$get_single_commission_data->total_bill}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                     <b>Shop Commission : </b>
                                     <span   >{{ number_format($get_single_commission_data->shop_commission_amount, 2) }}</span>
                                     <input type="hidden"  id="shop_commission_amount" value="{{$get_single_commission_data->shop_commission_amount}}">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                     <b>Agent Commission : </b>
                                     <span   >{{ number_format($get_single_commission_data->agent_commission_amount, 2) }}</span>
                                     <input type="hidden" id="agent_commission_amount" value="{{$get_single_commission_data->agent_commission_amount}}">
                                    </td>
                                </tr>

                                   <tr>
                                      
                                       <td colspan="2"> 
                                        <b>Agent Name :</b>
                                        <span id="agent_name">{{$get_single_commission_data->agent_name}}</span>
                                         
                                        </td>
                                   </tr>


                                   <tr>
                                      
                                       <td colspan="2" style="display:none;"> 
                                        <b>Agent Commission :</b>
                                        <span id="agent_commission">{{$get_single_commission_data->agent_commission_amount}}</span>
                                         
                                        </td>
                                   </tr>

                                    <tr>
                                       <td colspan="2">
                                           <b>Shop Name : </b>
                                           <span id="shop_name" >{{$get_single_commission_data->shop_name}}</span>
                                             <span id="shop_id" style="display:none;">{{$get_single_commission_data->shop_id}}</span>   
                                       </td>
                                   </tr>

                                   <tr>
                                      
                                        <td colspan="2"> 
                                            <b>Rack No : </b>
                                            <span id="rack_no">{{$get_single_commission_data->rack_code}}</span>
                                            
                                        </td>
                                   </tr>

                                   <tr style="display:none;">
                                       <th>Agent Conveynce</th>
                                       <td ><input type="text" class="form-control" readonly id="agent_conveynce" value="{{$conveynce_bill_parameter->agent_amount}}"></td>
                                   </tr>

                                   <tr style="display:none;">
                                       <th>Officer Conveynce</th>
                                       <td ><input class="form-control" readonly id="officer_conveynce" type="text" value="{{$conveynce_bill_parameter->officer_amount}}"> </td>
                                   </tr>


                                  

                                    
                                   
                                   <tr>
                                       <td colspan="2">
                                           <button type="button" class="btn btn-primary btn-block submit_btn">Bill Return</button>
                                       </td>
                                   </tr>
                                   
                                   <input type="hidden" id="location_redirect" value="{{url('bill-return/index')}}">
                                   <input type="hidden" id="vll_amount" value="{{ $get_single_commission_data->total_bill - $get_single_commission_data->shop_commission_amount }}">
                                </table>
                            </form> 

                        </div>
                    </div>

                </div>
            </div>

        </div>
    @endsection
    
   @push('js')     
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

    /*data table script*/
    </script>



    <script>

        
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





<script>
    $(".submit_btn").on("click", function(){

          
            var total_month = $("#total_month").val();
          
            var total_agent_conveynce_bill = total_month * agent_conveynce;

            var enter_amt =  $("#enter_amt").val();

            
    
            var officer_conveynce = $("#officer_conveynce").val();
            var total_officer_conveynce_bill = total_month * officer_conveynce;

            var enter_amt =  $("#enter_amt").val();



       
        var conveynce_month = $("#conveynce_month").html();
        var bill_no = $("#bill_no").html();
      
        var agent_name = $("#agent_name").html();
        var shop_name = $("#shop_name").html();
        var shop_id = $("#shop_id").html();
        var rack_no = $("#rack_no").html();
        

        var total_month = total_month;
        var location =  $("#location_redirect").val();

        var total_bill = $("#total_bill").val();
        var vll_amount = $('#vll_amount').val();
        var shop_commission_amount = $('#shop_commission_amount').val();
        var agent_commission_amount = $('#agent_commission_amount').val();
        
             
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

         cuteAlert({
          type: "question",
          title: "Do You Want To Authorize Bill Voucher ",
          message: "",
          confirmText: "Yes",
          cancelText: "Cancel"
        }).then((e)=>{
        
          if ( e == ("confirm")){

            var formData = {
                    conveynce_month:conveynce_month,
                    bill_no:bill_no,
                    agent_name:agent_name,
                    shop_name:shop_name,
                    shop_id:shop_id,
                    rack_no:rack_no,
                    total_month:total_month,
                    total_bill:total_bill,
                    vll_amount:vll_amount,
                    shop_commission_amount:shop_commission_amount,
                    agent_commission_amount:agent_commission_amount,
                
                };

                      $.ajax({
                        type: 'POST',
                        url: "{{ url('bill-return/single-bill-return-submit') }}",
                        data: formData,

                        beforeSend: function() {
                            loaderStart();
                        },

                    success: function(data) {
                  
                       
                       
                        console.log(data);

                        cuteAlert({
                                type      : "success",
                                title     : "Success",
                                message   : data.message,
                                buttonText: "ok"
                            }).then((e)=>{
                                window.location.replace(location);
                            });

                        
                },
                error: function(response) {

                        
                    cuteAlert({
                      type: "warning",
                      title: "Bill Return failed !",
                      message: "",
                      buttonText: "Okay",
                      timer: 10000
                    })

                },

                complete: function() {

                     loaderEnd();
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


        }) //end    
      
      
    });
</script>


@endpush


