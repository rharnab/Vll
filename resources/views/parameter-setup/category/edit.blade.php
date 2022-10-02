@extends('layouts.app')
@section('title','Category Setup')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Category Setup Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Category Setup Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="commission_form" action="{{ route('parameter_setup.category.update') }}" method="post" enctype="multipart/form-data">

                            	@csrf


                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="category_name"> Company Name </label>
                                           <input type="text" placeholder="Category Name" value="{{ $companies->name }}" name="category_name" class="form-control" id="category_name"  required>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>

                               <input type="hidden" id="edit_id" name="edit_id" value="{{ Crypt::encrypt($companies->id) }}">
                                
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
                    company_name: { required: true},
                    owner_name: { required: true},
                    contact_no: { required: true},
                    address: { required: true},
                    edit_id: { required: true},
                    
                },
                submitHandler: function(form) {
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? Update this Category",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('parameter_setup.category.update') }}',
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
                                            //location.reload(true);
                                            window.location ='{{ route('parameter_setup.category.index') }}'
                                        });
                                    }else if(data.status == 400){

                                        cuteAlert({
                                            type      : "warning",
                                            title     : "Warning",
                                            message   : data.message,
                                            buttonText: "ok"
                                        })


                                    }else{

                                        alert(data.message);                                        
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
