@extends('layouts.app')
@section('title','Rack Fillup')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Single Sale</li>
            <li class="breadcrumb-item active">Single Sales</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Single Packet/Socks Sale</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="rack-product-store"   method="post"  enctype="multipart/form-data" action="javascript:void(0)">

                            	@csrf
                                <div class="row">                                   

                                    <div class="form-group col-md-5 select_2_error">
                                        <label class="form-label" for="agent_id"> Select Agent</label>
                                        <select class=" form-control select2" style="text-transform: uppercase" id="agent_id" name="agent_id" required>
                                            <option value="">Select Agent</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}">{{ $agent->name }} - {{ $agent->mobile_number }}</option>
                                            @endforeach                         
                                        </select>
                                    </div>

                                    <div class="form-group col-md-5 select_2_error">
                                        <label class="form-label" for="agent_id"> Total Selected Product</label>
                                        <button type="button" class= "form-control btn btn-sm btn-outline-success">
                                            Total Shocks Collect For This Sale 
                                            <span class="badge bg-success-800 ml-2">
                                                <span id="collect_shocks">0</span>
                                            </span>
                                        </button>
                                    </div>

                                    <div class="form-group col-md-2 select_2_error">
                                        <label class="form-label" for="agent_id"></label>
                                        <div class="panel-content form-control border-faded border-left-0 border-right-0 border-bottom-0  border-top-0 d-flex flex-row align-items-center">
                                            <button class="btn btn-primary ml-auto waves-effect waves-themed" onclick="addNewField()" type="button"> <i class="fal fa-plus"></i> Add More</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="dynamic-add-field-container">

                                        </div>
                                    </div>
                                </div>
                                

                                <div class=" panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class=" submit_button btn btn-success ml-auto waves-effect waves-themed submit_btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>


    <input type="hidden" id="row_index" value="0">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="add_new_row_route" value="{{ route('direct_sale.add_new_row') }}">
    <input type="hidden" id="style_remaining_product_route" value="{{ route('rack.rack-fillup.style_remaining_product') }}">
    <input type="hidden" id="direct_product_store_route" value="{{ route('direct_sale.store') }}">
 
@endsection

@push('js')

    <script type="text/javascript">
        $(".submit_button").hide();
        function addNewField(){
            var index             = $(".packets_data").length;
            var add_new_row_route = $("#add_new_row_route").val();
            var _token            = $("#_token").val();
            var style_codes             = [];
            $.each($(".select_packets option:selected"), function(){            
                style_codes.push($(this).val());
            });
           
            $.ajax({
                type: 'POST',
                url : add_new_row_route,
                data: {
                    "_token"     : _token,
                    "style_codes": style_codes,
                    "index"      : index
                },
                beforeSend: function() {
                    loaderStart();
                },
                success: (data) => {
                   
                    $(".dynamic-add-field-container").append(data);   
                    $(".submit_button").show();
                    $(".select2").select2();
                },
                error: function(data) {
                   
                },
                complete: function() {
                    loaderEnd();
                }
            });
        }   
    </script>

    <script>
        function findRemainnigShocks(selectObject, index){
            var style_code                    = selectObject.value;
            var style_remaining_product_route = $("#style_remaining_product_route").val();
            var _token                        = $("#_token").val();
            $.ajax({
                type: 'POST',
                url : style_remaining_product_route,
                data: {
                    "_token"    : _token,
                    "index"     : index,
                    "style_code": style_code
                },
                beforeSend: function() {
                    loaderStart();
                },
                success: (data) => {
                   
                    $("#remaining_shocks_"+index).val(data.remaining_socks);  
                },
                error: function(data) {
                   
                },
                complete: function() {
                    loaderEnd();
                }
            });
            
        }
    </script>

    <script>
        function shockTakeForRack(){
            var sum = 0;
            $('.shocks_take_for_rack').each(function(){
                var val =  parseFloat($(this).val());
                if(isNaN(val)){
                    sum += 0;
                }else{
                    sum += val;
                }
            });
            
            $("#collect_shocks").html(sum);
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




            $("#rack-product-store").validate({
                rules: {
                    rack_id: {
                        required: true
                    },
                    shop_id: {
                        required: true
                    },
                    agent_id: {
                        required: true
                    }  
                },


                submitHandler: function(form) {
                    var direct_product_store_route = $('#direct_product_store_route').val();
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? You want to sale selected socks",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: direct_product_store_route,
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
                                           location.reload(true);
                                        });
                                    }else{
                                        cuteAlert({
											type: "error",
											title: "Error",
											message: data.message,
											buttonText: "Try Again"
										});                                 
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
