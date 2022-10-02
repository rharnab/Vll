@extends('layouts.app')
@section('title','Brand-Size-Edit')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Brand Size Edit Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Brand Size Edit Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('parameter_setup.brandsize.update') }}" method="post" enctype="multipart/form-data">

                            	@csrf

                                <input type="hidden" value="{{$get_data->id}}" name="hidden_id">

                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="company_name">Company Name</label>
                                          <select name="com_id" id="com_id" class="form-control select2" required>
                                            <option value="">Select Company</option>
                                            @foreach($company as $single_data)
                                                <option
                                                @if($single_data->id == $get_data->com_id)
                                                selected
                                                @endif
                                                value="{{ $single_data->id }}">{{ $single_data->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>                                
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                         <label class="form-label" for="name">Category </label>
                                            <select name="cat_id" id="cat_id" class="form-control select2" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $single_data)
                                                    <option
                                                    @if($single_data->id == $get_data->cat_id)
                                                    selected
                                                    @endif
                                                    value="{{ $single_data->id }}"> {{ $single_data->name }}</option>
                                                @endforeach
                                            </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>                                
                         
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Name</label>
                                        <input type="text" name="name" id="name" value="{{$get_data->name}}" class="form-control" required>

                                        <div class="valid-feedback">
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

            /* $.validator.addMethod('code_number', function(value) {
                
                return /\b(88)?01[3-9][\d]{8}\b/.test(value);
            }, 'Please enter valid code number');*/

           


        });


        $(".submit_btn").on('click', function(){

           var agent_branch_name = $("#agent_branch_name").val();
           // var fingerprint = $("#fingerprint").val();
           // var otp = $("#otp").val();
           // var form_submit = $("#form_submit").val();

            if (agent_branch_name=='') {

                cuteAlert({
                  type: "warning",
                  title: "Please, Select Branch",
                  message: "",
                  buttonText: "Okay"
                })

                return false;
            }


           var fingerprint = document.getElementById("fingerprint").checked;
           var otp = document.getElementById("otp").checked;
           var form_submit = document.getElementById("form_submit").checked;

           
            
            if (fingerprint==false && otp==false &&  form_submit==false) {
                
                cuteAlert({
                  type: "warning",
                  title: "Please, Select fingerprint or OTP or Form Submit ",
                  message: "",
                  buttonText: "Okay"
                })

                return false;
            }
        });


        //tostr message 
         @if(Session::has('message'))
          toastr.success("{{ session('message') }}");
          @endif
    </script>
@endpush
