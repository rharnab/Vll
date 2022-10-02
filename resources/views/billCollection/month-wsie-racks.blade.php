@extends('layouts.app')
@section('title','Bill-Collection')

@push('css')

 


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item">Month Wise  Bill Collection </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>


        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                          <h2>Month Wise  Bill Collection  Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="commission_form"  method="post" enctype="multipart/form-data" action="{{ route('bill.collection.monthly') }}">

                                @csrf

                                <input type="hidden" name="rack_code" value="" id="rack_code">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Shop </label>
                                        
                                        <select class="form-control select2" name="shop_id" id="shop_id" onchange="findAllDue()" required>
                                           <option value="">Select Shop</option>

                                            @foreach($all_due_shop as $single_shop)

                                              <option value="{{ $single_shop->shop_id }}">{{ $single_shop->shop_name }}</option>

                                           @endforeach
                                
                                            
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                               <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Select Month </label>
                                        
                                        <select class="form-control select2" name="due_month" id="due_month" required>
                                           <option value="">Select Month</option>
                                            
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Total Socks </label>
                                           <input readonly type="text" id="total_socks"   name="total_socks"  class="form-control" value=""  maxlength="10" >
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>

                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Due Amount </label>
                                           <input readonly type="text" id="bill_amount"   name="bill_amount"  class="form-control" value=""  maxlength="10" >
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="col-md-12 mb-3">

                                        <div class="frame-wrap">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                   <input type="checkbox" name="chk_full" class="custom-control-input" id="chk_full" checked>
                                                    <label class="custom-control-label" for="chk_full">Full Amount</label>
                                                </div>
                                                
                                               
                                            </div>
                                    </div>
                                      
                                </div>
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">Submit form</button>
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

<script type="text/javascript">

    function findAllDue()
    {
        var shop_id = $('#shop_id').val();

       if(shop_id !='')
       {
            $.ajax({

                type : "post",
                url : "{{ route('bill.collection.all_month') }}",
                data : {
                   
                   
                    'shop_id'  : shop_id,
                    '_token'  : '{{ @csrf_token() }}',

                },
                

                success: function(data)
                {
                    
                    $('#due_month').html(data);
                    console.log(data);

                }
               
            })
       }

       $('#bill_amount').val(0);
       $('#rack_code').val(0);
       $('#total_socks').val(0);
    }
 
</script>

<script type="text/javascript">
   $('#due_month').on('change', function(){


        var due_month = $('#due_month').val();
        var shop_id = $('#shop_id').val();

        if(due_month !='')
        {
            $.ajax({

                type : "post",
                url : "{{ route('bill.collection.show-bill') }}",
                data : {
                    'due_month' : due_month,
                    'shop_id'  : shop_id,
                    '_token'  : '{{ @csrf_token() }}',

                },
                dataType: 'json',
                cache: false,

                success: function(data)
                {
                    $('#bill_amount').val(data.total_due);
                    $('#rack_code').val(data.rack_code);
                    $('#total_socks').val(data.total_socks);
                    
                }
               
            })
        }

   })
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

        

            $("#commission_form").validate({
                rules: {
                    due_month: { required: true},
                    bill_amount: { required: true},
                    rack_code: { required: true},
                    shop_id: { required: true},
                   
                },
                submitHandler: function(form) {

                    var base_url = window.location.origin + '/';
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? Want to Pay this Bill",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('bill.collection.monthly') }}",
                                data: $(form).serialize(),
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
                                        $("#bill_collection_btn").prop('disabled', true);
                                       
                                        //window.location = base_url+"voucher/shop/rack-bill-info/"+data.bill_no;

                                        window.location = base_url+"voucher/shop/rack-bill-voucher/"+data.bill_no;
                                       
                                    });
                                }else{
                                    cuteAlert({
                                        type: "error",
                                        title: "Error",
                                        message: data.message,
                                        buttonText: "Try Again"
                                    });                                 
                                }


                                console.log(data);

                                  

                                                         
                                },
                                error: function(data) {
                                   
                                },
                                complete: function() {
                                    loaderEnd();
                                }
                            });
                            $form.submit();
                        }
                    })
                }
            });
        });
</script>






@endpush
