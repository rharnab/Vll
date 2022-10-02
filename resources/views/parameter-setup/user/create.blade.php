@extends('layouts.app')
@section('title','Account-type')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">User Create Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>User Create Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="user_create_from" action="{{ route('parameter_setup.user.store') }}" method="post" enctype="multipart/form-data">

                            	@csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                              

                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">NID Number</label>
                                            <input type="text" name="nid" id="nid" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>



                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Mobile Number</label>
                                            <input type="text" name="mobile" id="mobile" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Present Address</label>
                                            <input type="text" name="present_address" id="present_address" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Permanent Address</label>
                                            <input type="text" name="permanent_address" id="permanent_address" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                                

                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Role</label>
                                          <select class="form-control select2" name="role" required>
                                              <option value="">--select--</option>
                                              <option value="1">Admin</option>
                                              <option value="2">Agent User</option>
                                              <option value="3">Stock Manager</option>
                                              <option value="4">Account Manger</option>
                                              <option value="5">Shopkeeper user</option>
                                              <option value="8">Super Agent</option>
                                          </select>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                 <div class="form-row">
                                   
                                    <div class="col-md-12 mb-3">

                                        <label class="form-label" for="code">Image</label>
                                            <input type="file" name="image" id="image" class="form-control">

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


       


        //tostr message 
         @if(Session::has('message'))
          toastr.success("{{ session('message') }}");
          @endif
    </script>


     <script>
       $.validator.addMethod('mobile', function(value) {
            return /\b(88)?01[3-9][\d]{8}\b/.test(value);
        }, 'Please enter valid phone number');


        $("#user_create_from").validate({
            rules: {
                mobile: {
                    required: true,
                    mobile: true
                }
            },
            messages: {
                mobile: {
                    required: 'please enter your mobile number',
                }
            },
        });

    </script>

@endpush
