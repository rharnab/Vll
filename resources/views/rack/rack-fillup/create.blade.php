@extends('layouts.app')
@section('title','Rack Fillup')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Rack-Fillup</li>
            <li class="breadcrumb-item active">Socks Rack Fillup</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Rack Socks Fillup</h2>
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
                                    <div class="form-group col-md-4 select_2_error">
                                        <label class="form-label" for="rack_id"> Select Rack</label>
                                        <select class=" form-control select2" style="text-transform: uppercase" onchange="findOutRackSummary()" id="rack_id" name="rack_id" required>
                                            <option value="">Select Rack</option>
                                            @foreach($racks as $rack)
                                                <option value="{{ $rack->rack_code }}">{{ $rack->rack_code }} - {{ $rack->rack_category }} - (Max: {{ $rack->total_count }} Pair)</option>
                                            @endforeach                         
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 select_2_error">
                                        <label class="form-label" for="agent_id">Select Fillup Type</label>
                                        <select class=" form-control select2"  style="text-transform: uppercase" id="status" name="status" required>
                                            <option value="">Select Fillup Type</option>
                                            <option value="0">New</option>
                                            <option value="2">Re-Fill</option>                                                                   
                                        </select>
                                    </div>

                                     


                                    <div class="form-group col-md-4 select_2_error">
                                        <label for="">&nbsp;</label>
                                        <div class="form-control panel-content border-faded border-left-0 border-right-0 border-bottom-0  border-top-0 d-flex flex-row align-items-center">
                                              <button class="btn btn-success ml-auto waves-effect waves-themed  btn-sm" onclick="ShowDetails();" type="button"  > <i class="fas fa-socks" ></i> Show Details</button>

                                            <button class="btn btn-primary ml-auto waves-effect waves-themed btn-sm" onclick="addNewField()" type="button"> <i class="fal fa-plus"></i> Add More</button>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group col-md-3 select_2_error">
                                        <label class="form-label" for="agent_id"> Select Agent</label>
                                        <select class=" form-control select2" style="text-transform: uppercase" id="agent_id" name="agent_id" required>
                                            <option value="">Select Agent</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}">{{ $agent->name }} - {{ $agent->mobile_number }}</option>
                                            @endforeach                         
                                        </select>
                                    </div>
    
                                    <div class="form-group col-md-3 select_2_error">
                                        <label class="form-label" for="shop_id"> Select Shop</label>
                                        <select class=" form-control select2" style="text-transform: uppercase" id="shop_id" name="shop_id" required>
                                            <option value="">Select Shop</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach                         
                                        </select>
                                    </div>   --}}
                                </div>

                                <div class="row" id="socks_summation_calculation">
                                    
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



<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id=""> Socks Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>


    <input type="hidden" id="row_index" value="0">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="add_new_row_route" value="{{ route('rack.rack-fillup.add_new_row') }}">
    <input type="hidden" id="style_remaining_product_route" value="{{ route('rack.rack-fillup.style_remaining_product') }}">
    <input type="hidden" id="rack_product_store_route" value="{{ route('rack.rack-fillup.store') }}">
    <input type="hidden" id="types_find_packet_route" value="{{ route('rack.rack-fillup.types_find_packet') }}">
    <input type="hidden" id="rack_socks_history_route" value="{{ route('rack.rack-fillup.rack_socks_history') }}">
 
@endsection

@push('js')

    <script>
        function findOutRackSummary(){
            var rack_code                = $("#rack_id").val();
            var rack_socks_history_route = $("#rack_socks_history_route").val();
            var _token                   = $("#_token").val();
            if(rack_code != ''){
                $.ajax({
                    type: 'POST',
                    url : rack_socks_history_route,
                    data: {
                        "_token"   : _token,
                        "rack_code": rack_code,
                    },
                    beforeSend: function() {
                        loaderStart();
                    },
                    success: (data) => {
                    $("#socks_summation_calculation").html(data);
                    },
                    error: function(data) {
                       
                    },
                    complete: function() {
                        loaderEnd();
                    }
                });
            }            
        }
    </script>

    <script type="text/javascript">
        $(".submit_button").hide();
        function addNewField(){

            var index             = $(".packets_data").length;
            var add_new_row_route = $("#add_new_row_route").val();
            var _token            = $("#_token").val();
            $.ajax({
                type: 'POST',
                url : add_new_row_route,
                data: {
                    "_token"    : _token,
                    "index"     : index,
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

    <script type="text/javascript">
        function RemoveField(id){
            $("#row_id_"+id).html('');
        }
    </script>

    <script>
        function findTypeSocks(selectObject, index){
            var type_id = selectObject.value;
            if(type_id != ''){
                var types_find_packet_route = $("#types_find_packet_route").val();
                var _token                  = $("#_token").val();
                var style_codes             = [];
                $.each($(".select_packets option:selected"), function(){            
                    style_codes.push($(this).val());
                });
                $.ajax({
                    type: 'POST',
                    url : types_find_packet_route,
                    data: {
                        "_token"     : _token,
                        "type_id"    : type_id,
                        "index"      : index,
                        "style_codes": style_codes
                    },
                    beforeSend: function() {
                        loaderStart();
                    },
                    success: (data) => {
                        $("#socks_packet_"+index).empty().append(data);
                    },
                    error: function(data) {
                       
                    },
                    complete: function() {
                        loaderEnd();
                    }
                });
            }else{
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: "please select socks type",
                    buttonText: "Try Again"
                });  
            }
        }
    </script>


<script>
    function findCatType(selectObject, index){
        var cat_id = selectObject.value;
        if(cat_id != ''){
           
            var _token                  = $("#_token").val();
           
            $.ajax({
                type: 'POST',
                url : " {{ route('rack.rack-fillup.findCatType') }}",
                data: {
                    "_token"     : _token,
                    "cat_id"    : cat_id,
                    "index"      : index,
                   
                },
                beforeSend: function() {
                    loaderStart();
                },
                success: (data) => {
                    $("#type_"+index).empty().append(data);
                    console.log(data)
                },
                error: function(data) {
                   
                },
                complete: function() {
                    loaderEnd();
                }
            });
        }else{
            cuteAlert({
                type: "error",
                title: "Error",
                message: "please select socks type",
                buttonText: "Try Again"
            });  
        }
    }
</script>



    <script>
        function findRemainnigShocks(selectObject, index){
            var style_code = selectObject.value;
            var style_remaining_product_route = $("#style_remaining_product_route").val();
            var _token            = $("#_token").val();
            $.ajax({
                type: 'POST',
                url : style_remaining_product_route,
                data: {
                    "_token": _token,
                    "index" : index,
                    "style_code" : style_code
                },
                beforeSend: function() {
                    loaderStart();
                },
                success: (data) => {
                   
                    $("#remaining_shocks_"+index).val(data.remaining_socks);  
                    $("#single_pair_price_"+index).val(data.single_pair_price);  
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
            var maximum_capacity        = $("#maximum_capacity").html();
            var initial_collect_socks   = $("#initial_collect_socks").val();
            var initial_remainnig_socks = $("#initial_remainnig_socks").val();

            var sum = 0;
            $('.shocks_take_for_rack').each(function(){
                var val =  parseFloat($(this).val());
                if(isNaN(val)){
                    sum += 0;
                }else{
                    sum += val;
                }
            });

            var final_sum             = parseFloat(initial_collect_socks) + sum;
            var final_remainnig_socks = parseFloat(initial_remainnig_socks) - sum;

            
            $("#collect_shocks").html(final_sum);
            $("#remainnig_socks").html(final_remainnig_socks);
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
                    var rack_product_store_route = $('#rack_product_store_route').val();
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? You want to add selected product this Rack",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: rack_product_store_route,
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

                                   console.log(data)                   
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


    <script type="text/javascript">
        

        function ShowDetails(){


          var rack_id =  $("#rack_id").val();
           var _token            = $("#_token").val();

            if (rack_id=='') {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: "Please select rack before details",
                    buttonText: "Try Again"
                });   
                return false;
               
            }else{

                
                

                 $.ajax({
                    type: 'POST',
                    url : "{{route('rack.rack-fillup.rack_socks_details')}}",
                    data: {
                          "_token"   : _token,
                        "rack_id"     : rack_id,
                    },
                    beforeSend: function() {
                        loaderStart();
                    },
                    success: (data) => {
                        
                      

                        if (data) {
                           $(".modal-title").html(`<h2 ><span class='text-danger'> ${rack_id} </span> Current Available Socks Deatils</h2>`);  
                           $(".modal-body").html(data);  

                           $("#myModal").modal('show');  
                        }else{
                             cuteAlert({
                                    type: "warning",
                                    title: "warning",
                                    message: "No Data Found !",
                                    buttonText: "Okay"
                                });  

                                return false;
                        }

                       

                    },
                    error: function(data) {
                       
                    },
                    complete: function() {
                        loaderEnd();
                    }
                });

            }
        }
    </script>
  
  <script src="{{ asset('public/backend/assets/js/formplugins/validator/validate.min.js') }}"></script>
@endpush
