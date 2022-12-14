@extends('layouts.app')
@section('title','Agent-Dashboard')

@push('css')

<style>
    .p-3 {
        padding: 0.5rem !important;
    }
</style>

@endpush
@section('content')
<!-- BEGIN Page Content -->
       
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-transform: uppercase; font-size: 12px; font-weight:bold; text-align:center">
                    <i class="fal fa-usd-circle"></i> &nbsp; {{ $rack_info[0]->shop_name }} ( {{ $rack_info[0]->rack_code   }} ) Bill Collection
                </h4>
            </div>
        </div>

        <br>

        <div class="row" id="camission_calcualate_container">
            <div class="col-6 ">
                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="selected_shocks" style="font-size: 18px;">0 Pair</span>
                            <small class="m-0 l-h-n">Sales Socks Pair</small>
                        </h3>
                    </div>
                    <i class="fal fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-6 ">
                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="selected_shocks" style="font-size: 18px;">0 TK</span>
                            <small class="m-0 l-h-n">Total Bill</small>
                        </h3>
                    </div>
                    <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
            <div class="col-6 ">
                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="selected_shocks" style="font-size: 18px;">0 TK</span>
                            <small class="m-0 l-h-n">Shop Comission</small>
                        </h3>
                    </div>
                    <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>

            <div class="col-6 ">
                <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <span id="selected_shocks" style="font-size: 18px;">0 TK</span>
                            <small class="m-0 l-h-n">Agent Comission</small>
                        </h3>
                    </div>
                    <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>

            <div class="col-12">
                <button type="button" class="btn  btn-sm btn-danger waves-effect waves-themed w-100" disabled >  
                    SELECT SOCKS FOR BILL COLLECTION
                </button>
            </div>   
        </div>
        <br>
            
        <div class="row">
            <div class="col-md-12">
                <div id="panel-2" class="panel">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="accordion accordion-outline" id="m"> 

                                <div class="row">

                                {{--   @foreach($rack_shocks_array as $rack_shocks_size)
                                    <div class="col-md-2">
                                        <input  type="checkbox" name="payment_month" class="month_checkbox bill_month_{{ $rack_shocks_size['sold_date'] }}" onclick="selectBillMonth({{ $rack_shocks_size['sold_date'] }})"  value="{{ $rack_shocks_size['date'] }}"> 
                                        <label class="card-title">{{ date('Y M', strtotime($rack_shocks_size['date'])) }}</label>
                                    </div> 
                                 @endforeach --}}

                                 @foreach($sole_date_info as $single_sole_date_info)

                                    

                                     <div class="col-md-2">
                                        <input  type="checkbox" name="payment_month" class="month_checkbox bill_month_{{ $single_sole_date_info->sale_date }}" onclick="selectBillMonth({{ date('Ym', strtotime($single_sole_date_info->sale_date)) }})"  value="{{ $single_sole_date_info->sale_date }}"> 
                                        <label class="card-title">{{ date('Y M', strtotime($single_sole_date_info->sale_date)) }}</label>
                                    </div> 
                                   
                                 @endforeach

                                </div>  

    
                                @foreach($rack_shocks_array as $rack_shocks_size)
                                
                                    <div class="card">
                                        <div class="card-header">
                                               
                                           <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#1" onclick="collapaseShow({{ $rack_shocks_size['sold_date'] }})" aria-expanded="true">

                                            <i class="fal fa-socks width-2 fs-xl"></i>
                                            {{ date('Y M', strtotime($rack_shocks_size['date'])) }} - ( {{ $rack_shocks_size['total'] }} Pair)
                                            <span class="ml-auto">
                                                <span class="collapsed-reveal">
                                                    <i class="fal fa-minus fs-xl"></i>
                                                </span>
                                                <span class="collapsed-hidden">
                                                    <i class="fal fa-plus fs-xl"></i>
                                                </span>
                                            </span>
                                        </a>
                                             
                                        </div>
                                        <div id="m" class="collapse shocks_collapse_{{ $rack_shocks_size['sold_date'] }}" data-parent="#1">
                                            <div class="card-body">
                                                <div class="frame-wrap">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"  class="custom-control-input" id="{{ $rack_shocks_size['sold_date'] }}">
                                                        <label class="custom-control-label" onclick="selectAllSocks({{ $rack_shocks_size['sold_date'] }})" for="{{ $rack_shocks_size['sold_date'] }}">Select All {{ date('Y M', strtotime($rack_shocks_size['date'] )) }} Socks</label>
                                                    </div>

                                                    <hr>

                                                    <div class="demo">
                                                         @foreach($rack_shocks_size['shocks'] as $size_single_shocks)
                                                            <div class="custom-control custom-checkbox single_checkbox">
                                                                <input type="checkbox" onclick="countTotalSoldoutSocks('{{ $size_single_shocks['shocks_code'] }}')" class="select_items custom-control-input rack_single_shocks_{{  $rack_shocks_size['sold_date'] }}" value="{{ $size_single_shocks['shocks_code'] }}" id="{{ $size_single_shocks['shocks_code'] }}">
                                                                <label  class="custom-control-label" for="{{ $size_single_shocks['shocks_code'] }}">{{ $size_single_shocks['shop_socks_code'] ?? $size_single_shocks['print_shocks_code'] }} ({{  $size_single_shocks['brand_name'] }}) - {{ date('jS F,Y', strtotime($size_single_shocks['sold_mark_date_time'])) }}</label>
                                                            </div>
                                                        @endforeach                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              
                                @endforeach              
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    

        <input type="hidden" id="calculate_shocks_bill_route" value="{{ route('agent.rack.bill_collection.calculate_commission') }}">
        <input type="hidden" id="rack_scoks_bill_collect_route" value="{{ route('agent.rack.bill_collection.socks_bill_collection') }}">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="rack_code" value="{{ $rack_info[0]->rack_code }}">
        <input type="hidden" id="shop_id" value="{{ $rack_info[0]->shop_id }}">

@endsection

@push('js')

<script>
    function selectAllSocks(socks_size_id){
        var classname = "rack_single_shocks_"+socks_size_id;
        var select_all = $("#"+socks_size_id).is(':checked');
        if(select_all === false){
            $("input."+classname+":checkbox").prop('checked',true);
        }else{
            $("input."+classname+":checkbox").prop('checked',false);
        }

        console.log(socks_size_id);

        // show shocks list
        getSelectedBoxCount();  

        amountCalculation();    
        
    }

    function  getSelectedBoxCount(){
        var numberOfChecked = $('.select_items:checked').length;
        $("#selected_shocks").html(numberOfChecked);
    }

    function countTotalSoldoutSocks(shock_code){
        amountCalculation(); 
        var numberOfChecked = $('.select_items:checked').length;
        $("#selected_shocks").html(numberOfChecked); 
              
    }
     
    
</script>


<script>
    function amountCalculation(){
        var socks = []
        var checkboxes = document.querySelectorAll('.single_checkbox input[type=checkbox]:checked')

        for (var i = 0; i < checkboxes.length; i++) {
            socks.push(checkboxes[i].value)
        }
           
      
        var calculate_shocks_bill_route = $("#calculate_shocks_bill_route").val();
        var _token                      = $("#_token").val();
        var shop_id                     = $("#shop_id").val();

        

    
        $.ajax({
            type: 'POST',
            url: calculate_shocks_bill_route,
            data: {
                "shocks" : socks,
                "shop_id": shop_id,
                "_token" : _token,
            },
            beforeSend: function() {
                //  loaderStart();
            },
            success: (data) => {
                $("#camission_calcualate_container").html(data);               
            },
            error: function(data) {
               
            },
            complete: function() {
                // loaderEnd();
            }
        });
    }
</script>


<script>
    function shocksBillCollection(){

        var base_url = window.location.origin + '/';
        console.log(window.location.host);
       
        var socks = []
        var checkboxes = document.querySelectorAll('.single_checkbox input[type=checkbox]:checked')

        for (var i = 0; i < checkboxes.length; i++) {
            socks.push(checkboxes[i].value)
        }

        var bill_month = [];
         $.each($("input[name='payment_month']:checked"), function(){
            bill_month.push($(this).val());
        });
        

       

        if( socks.length > 0 && bill_month.length > 0 ){ 
            
            var rack_scoks_bill_collect_route = $("#rack_scoks_bill_collect_route").val();
            var rack_code                = $("#rack_code").val();
            var shop_id                  = $("#shop_id").val();
            var _token                   = $("#_token").val();

        cuteAlert({
                type       : "question",
                title      : "Confirmation",
                message    : "Are your sure ? You want to collect bill selected socks",
                confirmText: "Yes",
                cancelText : "No"
            }).then((e)=>{
                if (e == ("confirm")){
                    $.ajax({
                        type: 'POST',
                        url : rack_scoks_bill_collect_route,
                        data: {
                            "shocks"   : socks,
                            "rack_code": rack_code,
                            "shop_id": shop_id,
                            "_token"   : _token,
                            "bill_month" : bill_month,
                        },
                        beforeSend: function() {
                            loaderStart();
                        },
                        success: (data) => {
                           
                             /*if(data.status === 200){
                                cuteAlert({
                                    type      : "success",
                                    title     : "Success",
                                    message   : data.message,
                                    buttonText: "ok"
                                }).then((e)=>{
                                    $("#bill_collection_btn").prop('disabled', true);
                                   
                                    window.location = base_url+"voucher/shop/rack-bill-info/"+data.bill_no;
                                   
                                });
                            }else{
                                cuteAlert({
                                    type: "error",
                                    title: "Error",
                                    message: data.message,
                                    buttonText: "Try Again"
                                });                                 
                            } */
                            
                            console.log(data);
                        },
                        error: function(data) {
                           
                        },
                        complete: function() {
                            loaderEnd();
                        }
                    });
                }
            })
        }else{
            cuteAlert({
                type: "error",
                title: "Select Socks code and Payment month",
                message: "",
                buttonText: "Try Again"
            });  
        }
       
    }
</script>


<script>
    function collapaseShow(id){
        $(".shocks_collapse_"+id).toggleClass("show");
    }
</script>

<script type="text/javascript">
    function selectBillMonth(id)
    {
         $(".shocks_collapse_"+id).toggleClass("show");
    }
</script>





@endpush
