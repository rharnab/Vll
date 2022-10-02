@extends('layouts.app')
@section('title','Brand-Size')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Racks Create Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Racks Create Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('parameter_setup.racks.store') }}" method="post" enctype="multipart/form-data">

                            	@csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Rack Category</label>
                                        
                                        <select class="form-control select2" name="rack_category" required>
                                            <option value="">--select--</option>
                                            <option value="BIG">Big</option>
                                            <option value="MEDIUM">Medium</option>
                                            <option value="SMALL">Small</option>
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                              

                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Select Rack Level</label>
                                            
                                            <select class="form-control select2" name="rack_level" required>
                                                <option value="">--select--</option>

                                                <option value="4">4</option>
                                                <option value="2">2</option>

                                            </select>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                <div class="form-row">
                                   

                                    <div class="col-md-12 mb-3">
                                      <label class="form-label" for="product_type">Product Type</label>
                                          
                                          <select class="form-control select2" name="product_type" required>
                                              <option value="">--select Type --</option>

                                              <option value="1">Socks</option>
                                              <option value="2">Socks + Tshirt</option>
                                              <option value="3">Socks + Tshirt + Pant</option>

                                          </select>

                                      <div class="valid-feedback"></div>

                                  </div>
                                  
                              </div>


                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Total Count</label>
                                            
                                           <input type="text" name="total_count" class="form-control">

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
