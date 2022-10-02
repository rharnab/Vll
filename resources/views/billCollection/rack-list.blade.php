@extends('layouts.app')
@section('title','Bill-Collection')

@push('css')

 


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item">ALL Due Bill Collection</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>


        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                          <h2>All Due Collection Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="commission_form"  method="post" enctype="multipart/form-data" action="{{ route('bill.collection.pay_all_due') }}">

                                @csrf

                                <input type="hidden" name="shop_id" id="shop_id">

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Shop </label>
                                        
                                        <select class="form-control select2" name="rack_code" id="rack_code" onchange="findAllDue()" required>
                                           <option value="">Select Shop</option>

                                           @foreach($all_due_shop as $single_shop)

                                              <option value="{{ $single_shop->rack_code }}">{{ $single_shop->shop_name }}</option>

                                           @endforeach
                                          
                                           
                                            
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Total Sokcs</label>
                                           <input readonly type="text"   name="total_socks"  class="form-control" id="total_socks" value="0.00">
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>

                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Due Amount </label>
                                           <input readonly type="text"   name="due_amount"  class="form-control" id="due_amount" value="0.00">
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>

                               

                                <div class="form-row pay_amount_area" >
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code"> Number Of Month </label>
                                           <input readonly type="text" placeholder="Total Due month" name="num_of_month"  class="form-control" id="num_of_month" value="0">
                                        <div class="valid-feedback"></div>

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
        var rack_code = $('#rack_code').val();


       if(rack_code !='')
       {
            $.ajax({

                type : "post",
                url : "{{ route('bill.collection.all_due') }}",
                data : {
                   
                   
                    'rack_code'  : rack_code,
                    '_token'  : '{{ @csrf_token() }}',

                },
                dataType: 'json',
                cache: false,

                success: function(data)
                {
                    
                    $('#due_amount').val(data.total_due);
                    $('#num_of_month').val(data.total_due_month);
                    $('#shop_id').val(data.shop_id);
                    $('#total_socks').val(data.total_socks);
                    
                    console.log(data);

                }
               
            })
       }
    }
 
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
                    due_amount: { required: true},
                    num_of_month: { required: true},
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
                                url: "{{ route('bill.collection.pay_all_due') }}",
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
