@extends('layouts.app')
@section('title','Rack Fillup')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Agent Create Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Agent Create Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('parameter_setup.agent.store') }}" method="post">

                            	@csrf
                                <div class="row">
                                    <div class="form-group col-md-4 select_2_error">
                                        <label class="form-label" for="rack_id"> Select Rack</label>
                                        <select class=" form-control select2" style="text-transform: uppercase" id="rack_id" name="rack_id" required>
                                            <option value="">Select Rack</option>
                                            @foreach($racks as $rack)
                                                <option value="{{ $rack->id }}">{{ $rack->rack_code }} - {{ $rack->rack_category }}</option>
                                            @endforeach                         
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 select_2_error">
                                        <label class="form-label" for="agent_id"> Select Agent</label>
                                        <select class=" form-control select2" style="text-transform: uppercase" id="agent_id" name="agent_id" required>
                                            <option value="">Select Agent</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}">{{ $agent->name }} - {{ $agent->mobile_number }}</option>
                                            @endforeach                         
                                        </select>
                                    </div>
    
                                    <div class="form-group col-md-4 select_2_error">
                                        <label class="form-label" for="shop_id"> Select Shop</label>
                                        <select class=" form-control select2" style="text-transform: uppercase" id="shop_id" name="shop_id" required>
                                            <option value="">Select Shop</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach                         
                                        </select>
                                    </div>  
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                            <button class="btn btn-primary ml-auto waves-effect waves-themed" onclick="addNewField()" type="button"> <i class="fal fa-plus"></i> Add More</button>
                                        </div>
                                    </div>                                    
                                </div>

                                <div class="row">

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


    <input type="hidden" id="row_index" value="0">
 
@endsection

@push('js')

    <script>
        function addNewField(){
            
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
