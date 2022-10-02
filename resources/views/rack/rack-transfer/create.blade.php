@extends('layouts.app')
@section('title','Account-type')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Rack</li>
            <li class="breadcrumb-item active">Transfer Rack Mapping</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Transfer Rack Mapping</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="rack-mapping-store"   method="post"  enctype="multipart/form-data" action="{{ route('rack.transfer.store') }}">

                            	@csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Select Rack</label>                                        
                                        <select class="form-control select2" name="rack_code" required>
                                            <option value="">Select Rack</option>
                                            @foreach($racks as $rack)
                                                <option value="{{ $rack->rack_code }}"> {{ $rack->rack_code }}  - {{ $rack->rack_category }} - {{ $rack->total_count }} </option>
                                            @endforeach 
                                        </select>
                                    </div>  
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Select Agent</label>                                        
                                        <select class="form-control select2" name="agent_id" required>
                                            <option value="">Select Agent</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}"> {{ $agent->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>  
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Select Shop</label>                                        
                                        <select class="form-control select2" name="shop_id" required>
                                            <option value="">Select Shop</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}"> {{ $shop->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>  
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Rack Delivery Date </label>                                        
                                        <input type="date" class="form-control"  name ="rack_delivery_date">
                                    </div>  
                                </div>
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">RACK-TRANSFER</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
 <input type="hidden" id="rack_mapping_store" value="{{ route('rack.transfer.store') }}">
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




           $("#rack-mapping-store").validate({
               rules: {
                   rack_code: {
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
                   var rack_mapping_store = $('#rack_mapping_store').val();
                   cuteAlert({
                       type       : "question",
                       title      : "Confirmation",
                       message    : "Are your sure ? You want to mapping this rack",
                       confirmText: "Yes",
                       cancelText : "No"
                   }).then((e)=>{
                       if (e == ("confirm")){
                           $.ajax({
                               type: 'POST',
                               url: rack_mapping_store,
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

<script src="{{ asset('public/backend/assets/js/formplugins/validator/validate.min.js') }}"></script>
@endpush
