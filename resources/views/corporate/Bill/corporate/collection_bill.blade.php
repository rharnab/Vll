@extends('layouts.app')
@section('title','Direct Sale Bill Collection')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Bill Collection</li>
            <li class="breadcrumb-item active">Corporate Bill Collection</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Corporate Bill Collection</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('direct_sale.bill-collection.bill_store') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf

                            
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="shop">Select Client</label>
                                       
                                        <select name="client_id" id="client_id" class="form-control select2"  required>
                                            <option value="">--select--</option>
                                            @foreach($all_due_client as $single_client)
                                                <option value="{{$single_client->client_id}}">{{$single_client->client_name}}</option>
                                           @endforeach

                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="challan_no">Challan No.</label>
                                       
                                        <select name="challan_no" id="challan_no" class="form-control select2"  required>
                                            <option value="">--select--</option>

                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="total_qty">Total Quantity </label>
                                       
                                       <input type="text" class="form-control" name="total_qty" id="total_qty" readonly>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="total_amount">Total Amount</label>
                                       
                                       <input type="text" class="form-control" name="total_amount" id="total_amount" readonly>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="paid_amount">Paid Amount</label>
                                       
                                       <input type="text" class="form-control" name="paid_amount" id="paid_amount" readonly>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="due_amount">Due Amount</label>
                                       
                                       <input type="text" class="form-control" name="due_amount" id="due_amount" readonly>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="bill_collection_amount">Bill Collection Amount</label>
                                       
                                       <input type="text" class="form-control" name="bill_collection_amount" id="bill_collection_amount">
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="button">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
 
@endsection

@push('js')

    <script>
        $('#client_id').on('change', function(){
            var client_id = $("#client_id").val();
            
               $("#total_amount").val('');
               $("#paid_amount").val('');
                $("#due_amount").val('');
                $("#bill_collection_amount").val('');

            if(client_id !='')
            {   
                
                $.ajax({
                    type:"POST",
                    url:"{{ route('corporate.bill.challan_no') }}",
                    data:{
                        client_id: client_id,
                        "_token": " {{ csrf_token() }} ",
                    },
                    success:function(data)
                    {
                      
                      $("#challan_no").html(data);
                      //console.log(data);
                     
                    }
                });

                

            }
        })
    </script>


<script>
    $("#challan_no").on("change", function(){
       var client_id = $("#client_id").val();
       var challan_no = $("#challan_no").val();

     
        $.ajax({
                type:"POST",
                url:"{{ route('corporate.bill.amount') }}",
                data:{
                    client_id: client_id,
                    challan_no: challan_no,
                    "_token": " {{ csrf_token() }} ",
                },
                success:function(data)
                {
                    
                    var json_data = JSON.parse(data);
                    $("#total_qty").val(json_data.total_qty);
                    $("#total_amount").val(json_data.total_bill);
                    $("#paid_amount").val(json_data.total_paid);
                    $("#due_amount").val(json_data.total_due);
                    //console.log(json_data.total_due)
                    
                }
            });
    });
</script>


<script>
    $(".submit_btn").on("click", function(){
        
        var challan_no = $("#challan_no").val();
        var total_amount = $("#total_amount").val();
        var paid_amount = $("#paid_amount").val();


       var due_amount = $("#due_amount").val();
        
       if(due_amount==''){
        cuteAlert({
                type      : "warning",
                title     : "Warning",
                message   : 'Enter due amount',
                buttonText: "ok"
            });
        return false;
       }

       
       var bill_collection_amount = $("#bill_collection_amount").val();
       
       if(bill_collection_amount==''){
            cuteAlert({
                    type      : "warning",
                    title     : "Warning",
                    message   : 'Enter bill collection amount',
                    buttonText: "ok"
                });
            return false;

        }
    //    alert(due_amount);
    //    alert(bill_collection_amount);
        var bill_collection_amt = parseInt(bill_collection_amount);
        var due_amt = parseInt(due_amount);

        if(bill_collection_amt > due_amt){
            
            cuteAlert({
                    type      : "warning",
                    title     : "Warning",
                    message   : 'Bill collection amount can not greater than due amount',
                    buttonText: "ok"
                });

                return false;
            }

            cuteAlert({
            type: "question",
            title: "Confirm Title",
            message: "Do you want create this transaction ??",
            confirmText: "Okay",
            cancelText: "Cancel"
            }).then((e)=>{
               
            if ( e == ("confirm")){
                
                $.ajax({
                type:"POST",
                url:"{{ route('corporate.bill.bill_store') }}",
                data:{
                    challan_no: challan_no,
                    total_amount: total_amount,
                    paid_amount: paid_amount,
                    due_amt: due_amt,
                    bill_collection_amt: bill_collection_amt,
                    "_token": " {{ csrf_token() }} ",
                },
                success:function(data)
                {
                    
                    cuteAlert({
                        type      : "success",
                        title     : "success",
                        message   : data.message,
                       
                    })
                    .then((e)=>{
                        location.reload(true);
                    })
                   

                   
                    
                }
            });

            }
            })


           

    });

</script>
    <script>
        $(function() {

             var $form = $(this);

            $.validator.setDefaults({
                errorClass: 'help-block',
                highlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .removeClass('has-error');
                }
            });

        });
    </script>
@endpush
