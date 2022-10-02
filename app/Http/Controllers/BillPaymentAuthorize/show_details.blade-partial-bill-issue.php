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
            <li class="breadcrumb-item active"> Bill Authorize </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-8">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                    Bill Authorize   {{$get_data_shocks_bill->voucher_link}}
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
                         <h2> Bill Authorize </h2>
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
                                     <span  id="bill_no" >{{ number_format($get_single_commission_data->total_bill, 2) }}</span>
                                     
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                     <b>Shop Commission : </b>
                                     <span  id="bill_no" >{{ number_format($get_single_commission_data->shop_commission_amount, 2) }}</span>
                                     
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                     <b>Agent Commission : </b>
                                     <span  id="bill_no" >{{ number_format($get_single_commission_data->agent_commission_amount, 2) }}</span>
                                     
                                    </td>
                                </tr>
                                
                                
                                <tr>
                                    <td colspan="2">
                                        <b>Factory Amount : </b>
                                        <span  id="venture_amount" >
                                            @php 
                                              echo  $get_single_commission_data->factory_bill;

                                            @endphp
                                        </span>
                                        
                                    </td>

                                </tr>
                                
                                
                                 <tr>
                                    <td colspan="2">
                                        <b>Venture Amount : </b>
                                        <span  id="venture_amount" >
                                            @php 
                                              echo  $get_single_commission_data->total_bill - ($get_single_commission_data->shop_commission_amount +  $get_single_commission_data->factory_bill + $get_single_commission_data->agent_commission_amount);

                                            @endphp
                                        </span>
                                        
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
                                        <b>Select Agent / Officer : </b> <br>
                                        <input type="radio" name="emp" id="agent" value="Agent" 
                                        <?php 
                                        if($get_user_data->is_officer==0){
                                            echo "checked";
                                        } ?>>
                                        <label for="Agent">Agent</label> &nbsp;

                                        <input type="radio" name="emp" id="officer" value="Officer"
                                        
                                        <?php 
                                        if($get_user_data->is_officer==1){
                                            echo "checked";
                                        } ?>>
                                        <label for="Officer">Officer</label>
                                       </td>
                                   </tr>


                                   <tr>
                                    
                                    @if(isset($last_partial_info->agent_name))
                                    <tr>
                                        <td colspan="2">
                                            <b>Last Paid By : </b>
                                            <span id="shop_name" >{{$last_partial_info->agent_name}}</span>
                                                 
                                        </td>
                                    </tr>
    
                                    <tr>
                                        <td colspan="2">
                                            <b>Received By : </b>
                                            <span id="shop_name" >{{$last_partial_info->auth_name}}</span>
                                                 
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2">
                                            <b>Paid Amount : </b>
                                            <span id="shop_name" >{{$total_paid}}</span>
                                                 
                                        </td>
                                    </tr>
                                      
                                      <td colspan="2">
                                          <b for="">Select Employee : </b>
                                          <select name="select_emp" id="select_emp" class="form-controll select2">
                                          <option value="">--select--</option>
                                              @foreach($agent_user as $single_agent_user)
                                               
                                               <option value="{{$single_agent_user->id}}" 
                                                
                                                <?php 
                                                if($get_single_commission_data->entry_user_id==$single_agent_user->id){
                                                    echo "selected";
                                                }

                                                ?>
                                               >{{$single_agent_user->name}}</option>

                                              @endforeach
                                          </select>
                                      </td>
                                  </tr>


                      

                                  <tr>
                                    <td colspan="2">
                                       
                                       
                                        
                                        @php 
                                        $total_billing_amount= $get_single_commission_data->total_bill - ($get_single_commission_data->shop_commission_amount +  $get_single_commission_data->agent_commission_amount);
                                        $due_amt = $total_billing_amount - $total_paid;
                                         @endphp
                                        <span class="text-danger"> <b>Due Amount:  {{ $due_amt }}</b></span> <br>
                                        <b>Received Amount : </b>
                                     
                                        <input type="text" id="paid_amount" required value="{{ $due_amt }}" class="form-control">
                                        <input type="hidden" id="bill_due_amount" value="{{  $total_billing_amount - $total_paid }}">
                                    </td>

                                </tr>

                                   @if($is_agent_convence_pay == 0)
                                   <tr>
                                        <td colspan="2">
                                            <span class="text-danger"> <b>Paid Conveynce Amount:  {{ $total_convence_paid }}</b></span> <br>
                                            <b>Enter Conveynce Amount : </b> <br>
                                          
                                            <input type="text" id="enter_amt" value="" class="form-control" >
                                           
                                       </td>
                                   </tr>
                                   @endif

                                 

                                   
                                       
                                        <tr class="tr_disp" style="<?php if($get_user_data->is_officer=='1'){ echo 'display:none';}  ?>">
                                            <td colspan="2">
                                                <b>Agent Commission : </b> <br>
                                                <input type="text" id="get_agent_commission" value="{{$get_single_commission_data->agent_commission_amount}}" class="form-control">
                                            </td>
                                        </tr>

                                   
                                   <tr>
                                       <td colspan="2">
                                           <button type="button" class="btn btn-primary btn-block submit_btn">Authorize</button>
                                       </td>
                                   </tr>
                                   
                                   <input type="hidden" id="location_redirect" value="{{url('bill-authorize/index')}}">
                                    <input type="hidden" id="vll_amount" value="{{ $get_single_commission_data->total_bill - $get_single_commission_data->shop_commission_amount }}">
                                </table>
                            </form> 

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

<script>
    var total_month=0;
    $("#enter_amt").val('');
     var total_month = $("#total_month").val();
     var total_conveynce_bill = 0;

     if($('#agent').is(':checked')) {

        var agent_conveynce = $("#agent_conveynce").val();
        var total_conveynce_bill = total_month * agent_conveynce;
        $("#enter_amt").val(total_conveynce_bill);

    }else if($('#officer').is(':checked')){
    
        var officer_conveynce = $("#officer_conveynce").val();
        var total_conveynce_bill = total_month * officer_conveynce;
        $("#enter_amt").val(total_conveynce_bill);
    }
</script>

<script>
    


    $("#agent").on("change", function(){
          
        var agent_conveynce = $("#agent_conveynce").val();
        var total_conveynce_bill = total_month * agent_conveynce;
        $("#enter_amt").val(total_conveynce_bill);
      
        $(".tr_disp").css('display','');

       
    });

    $("#officer").on("change", function(){

        $(".tr_disp").css('display','none');
        
        var officer_conveynce = $("#officer_conveynce").val();
        var total_conveynce_bill = total_month * officer_conveynce;
        $("#enter_amt").val(total_conveynce_bill);
      
        
    });

</script>

<script>
    $(".submit_btn").on("click", function(){
    
        
        
       if($('#agent').is(':checked')) { 

            var bill_receive_emp_type = "Agent";
            var total_month = $("#total_month").val();
            var agent_conveynce = $("#agent_conveynce").val();
            var agent_commission = $("#agent_commission").html();
           
            var get_agent_commission = $("#get_agent_commission").val();
            
           
            var total_agent_conveynce_bill = total_month * agent_conveynce;

            var enter_amt =  $("#enter_amt").val();

        
           /*  if(enter_amt > total_agent_conveynce_bill){

                cuteAlert({
                    type: "warning",
                    title: "Sorry , Conveynce Bill Only "+total_agent_conveynce_bill+" Tk",
                    message: "",
                    buttonText: "Okay"
                    });

                return false;

            } */

        
       
            if(get_agent_commission==''){

                    cuteAlert({
                            type: "warning",
                            title: "Please, Enter Agent Commision",
                            message: "",
                            buttonText: "Okay"
                            });

                        return false;

            }

            if(get_agent_commission>agent_commission){
                cuteAlert({
                    type: "warning",
                    title: "Sorry , Agent Commission Only "+agent_commission+" Tk",
                    message: "",
                    buttonText: "Okay"
                    });

                return false;
            }
           
        }else if($('#officer').is(':checked')){

            var bill_receive_emp_type = "Officer";
            
            var total_month = $("#total_month").val();
            var officer_conveynce = $("#officer_conveynce").val();
            var total_officer_conveynce_bill = total_month * officer_conveynce;

            var enter_amt =  $("#enter_amt").val();

            /* if(enter_amt > total_officer_conveynce_bill){

               

                cuteAlert({
                    type: "warning",
                    title: "Sorry , Conveynce Bill Only "+total_officer_conveynce_bill+" Tk",
                    message: "",
                    buttonText: "Okay"
                    })

                return false;

            } */

        }else{
                cuteAlert({
                    type: "warning",
                    title: "Please select Agent Or Officer",
                    message: "",
                    buttonText: "Okay"
                });

                return false;
        }


        if(enter_amt==''){

            cuteAlert({
                type: "warning",
                title: "Please, Enter Conveynce Amount ",
                message: "",
                buttonText: "Okay"
                });

            return false;
        }


        var select_emp = $("#select_emp").val();

        if(select_emp==''){
            
            cuteAlert({
                    type: "warning",
                    title: "Please select Employee",
                    message: "",
                    buttonText: "Okay"
                });

                return false;

        }

        var conveynce_month = $("#conveynce_month").html();
        var bill_no = $("#bill_no").html();
      
        var agent_name = $("#agent_name").html();
        var shop_name = $("#shop_name").html();
        var rack_no = $("#rack_no").html();
        
        var bill_receive_employee_type = bill_receive_emp_type;
        var total_month = total_month;
        var location =  $("#location_redirect").val();
        
        var vll_amount = $('#vll_amount').val();
        var convence = $('#enter_amt').val();
        var commission = $('#get_agent_commission').val();
        var paid_amount = $("#paid_amount").val();
        var bill_due_amount = $("#bill_due_amount").val();

        var num = /^-?\d*(\.\d+)?$/;
        if(!paid_amount.match(num) || !convence.match(num))
        {
            cuteAlert({
                    type: "warning",
                    title: "Please give only number",
                    message: "",
                    buttonText: "Okay"
                    });

                return false;
        }

        if(paid_amount == '')
        {
            cuteAlert({
                    type: "warning",
                    title: "Please give paid amount",
                    message: "",
                    buttonText: "Okay"
                    });

                return false;
        }

        if( vll_amount < (parseFloat(convence) + parseFloat(commission))){ // auth convence bill payment check
             cuteAlert({
                    type: "warning",
                    title: "Sorry , Collection  Bill not permit to process",
                    message: "",
                    buttonText: "Okay"
                    });

                return false;
        }
        
        
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
                    rack_no:rack_no,
                    bill_receive_employee_type:bill_receive_employee_type,
                    select_emp:select_emp,
                    enter_amt:enter_amt,
                    total_month:total_month,
                    get_agent_commission:get_agent_commission,
                    paid_amount: paid_amount,
                    bill_due_amount: bill_due_amount

                };

                      $.ajax({
                        type: 'POST',
                        url: "{{ url('bill-authorize/agent-or-officer-conveynce-bill-submit') }}",
                        data: formData,

                        beforeSend: function() {
                            loaderStart();
                        },

                    success: function(data) {
                  
                        console.log(data);

                        if(data=='0'){

                            cuteAlert({
                                type: "warning",
                                title: "  Already Authorized !",
                                message: "",
                                buttonText: "Okay",
                                timer: 10000
                            });

                            return false;

                        }

                        if(data.is_error == true){

                        cuteAlert({
                            type: "warning",
                            title: "Warning",
                            message: data.message,
                            buttonText: "Okay",
                            timer: 10000
                        });

                        return false;

                        }

                        if(data.message == true){
                            cuteAlert({
                            type: "success",
                            title: "Authorized Successful !",
                            message: data.message,
                            buttonText: "Okay"
                            }).then((e)=>{
                                window.location.replace(location);
                            });
                        }else{
                            cuteAlert({
                            type: "success",
                            title: "success !",
                            message: "Authorized Successful !",
                            buttonText: "Okay"
                            }).then((e)=>{
                                window.location.replace(location);
                            });
                        }
                       


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


