@extends('layouts.app')
@section('title','Commission Setup')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Commission Setup Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Commission Setup Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="commission_form" action="{{ route('parameter_setup.commission.store') }}" method="post" enctype="multipart/form-data">

                            	@csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Select Shop </label>
                                        
                                        <select class="form-control select2" name="shop_id" id="shop_id" required>
                                            <option value="0">ALL</option>

                                           

                                            @foreach($shops as $single_shop)

                                            <option value="{{ $single_shop->id }}"> {{ $single_shop->name }}  - {{ $single_shop->area }} </option>


                                            @endforeach
                                            
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>



                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Starting Range </label>
                                           <input type="text" placeholder="Starting Range" name="starting_range" class="form-control" id="starting_range" maxlength="10" required>
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>


                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Ending Range </label>
                                           <input type="text" placeholder="Ending Range" name="ending_range" class="form-control" id="ending_range" maxlength="10" required>
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>


                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Agent Commission(%)</label>
                                           <input type="text" placeholder="Agent Commission" name="agent_commission" class="form-control" id="agent_commission" maxlength="2" required>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>


                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code"> Shop Commission(%) </label>
                                           <input type="text" placeholder="Shop Commission" name="shop_commission" class="form-control" id="shop_commission" maxlength="2" required>
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


    <!-- <input type="hidden" valule="{{ route('parameter_setup.commission.store') }}" id="parameter_setup_commission_store"> -->
 
@endsection

@push('js')

<script>

        // $.validator.addMethod('phone', function(value) {
        //     return /\b(88)?01[3-9][\d]{8}\b/.test(value);
        // }, 'Please enter valid phone number');

        $.validator.addMethod('number', function(value) {
            return /^\d+$/.test(value);
        }, 'Please enter Only number');
        
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
                    shop_id: { required: true},
                    starting_range: { required: true, number: true},
                    ending_range: { required: true, number: true},
                    agent_commission: { required: true, number: true},
                    shop_commission: { required: true, number: true},  
                },
                submitHandler: function(form) {
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? Add this commission",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('parameter_setup.commission.store') }}',
                                data: $(form).serialize(),
                                beforeSend: function() {
                                    loaderStart();
                                },
                                success: (data) => {
                                    if(data.status == 200){
                                        cuteAlert({
                                            type      : "success",
                                            title     : "Success",
                                            message   : data.message,
                                            buttonText: "ok"
                                        }).then((e)=>{
                                            location.reload(true);
                                        });
                                    }else if(data.status == 400){

                                        cuteAlert({
                                            type      : "warning",
                                            title     : "Warning",
                                            message   : "Sorry product type not match",
                                            buttonText: "ok"
                                        })


                                    }else{

                                        alert(data.message);                                        
                                    }

                                  

                                                         
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
