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
            <li class="breadcrumb-item active">Direct Sale Bill Collection</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Direct Sale Bill Collection</h2>
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
                                        <label class="form-label" for="shop">Select Shop</label>
                                       
                                        <select name="shop_id" id="shop_id" class="form-control select2"  required>
                                            <option value="">--select--</option>
                                           
                                            @foreach($shops as $single_shops)
                                                <option value="{{$single_shops->id}}">{{$single_shops->name}}</option>
                                           @endforeach

                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="voucher_no">Voucher</label>
                                       
                                        <select name="voucher_no" id="voucher_no" class="form-control select2"  required>
                                            <option value="">--select--</option>

                                        </select>
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
        $('#shop_id').on('change', function(){
            var shop_id = $("#shop_id").val();
            
               $("#total_amount").val('');
               $("#paid_amount").val('');
                $("#due_amount").val('');
                $("#bill_collection_amount").val('');

            if(shop_id !='')
            {   
                
                $.ajax({
                    type:"POST",
                    url:"{{ route('direct_sale.bill-collection.get_voucher') }}",
                    data:{
                        shop_id: shop_id,
                        "_token": " {{ csrf_token() }} ",
                    },
                    success:function(data)
                    {
                      
                      $("#voucher_no").html(data);
                     
                    }
                });

                

            }
        })
    </script>


<script>
    $("#voucher_no").on("change", function(){
       var shop_id = $("#shop_id").val();
       var voucher_no = $("#voucher_no").val();

     
        $.ajax({
                type:"POST",
                url:"{{ route('direct_sale.bill-collection.get_amount') }}",
                data:{
                    shop_id: shop_id,
                    voucher_no: voucher_no,
                    "_token": " {{ csrf_token() }} ",
                },
                success:function(data)
                {
                    
                    var json_data = JSON.parse(data);
                    $("#total_amount").val(json_data.total_amount);
                    $("#paid_amount").val(json_data.total_paid);
                    $("#due_amount").val(json_data.total_due_amount);
                    
                }
            });
    });
</script>


<script>
    $(".submit_btn").on("click", function(){
        
        var voucher_no = $("#voucher_no").val();
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
            message: "Confirm Message",
            confirmText: "Okay",
            cancelText: "Cancel"
            }).then((e)=>{
               
            if ( e == ("confirm")){
                
                $.ajax({
                type:"POST",
                url:"{{ route('direct_sale.bill-collection.bill_store') }}",
                data:{
                    voucher_no: voucher_no,
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
                        message   : 'Bill collection successfully',
                       
                    });

                    location.reload(true);
                    
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
