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
                <h4 style="text-transform: uppercase; font-weight:bold; text-align:center">
                    <i class="fal fa-shopping-bag"></i> &nbsp; {{ $rack_info[0]->shop_name }} ( {{ $rack_info[0]->rack_code   }} )
                    <a  class="btn btn-danger float-right" href="{{ route('agent.sold_delete.rack_sold_information', [Crypt::encrypt( $rack_info[0]->rack_code )]) }}">Wrong sold</a>
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
                </div>
            </div>

            <div class="col-12">
                <button type="button" class="btn  btn-sm btn-danger waves-effect waves-themed w-100" disabled >  
                    SELECT SOCKS PAIR
                </button>
            </div>


           <!-- <div class="col-md-4 col-sm-12">
                {{-- <button type="button" class="btn btn-sm btn-outline-dark waves-effect waves-themed w-100">Soldout Socks Piar 
                    <span class="badge  bg-fusion-300 ml-2">
                        <span id="selected_shocks">0</span>
                    </span>
                </button> --}}
                <div id="camission_calcualate_container">
                    <br>
                    <button type="button" class="btn btn-sm btn-outline-dark waves-effect waves-themed w-100"> Total Bill
                        <span class="badge  bg-fusion-300 ml-2">
                            <span id="selected_shocks">0 TK</span>
                        </span>
                    </button>
                    <br>
                    <br>
                    <button type="button" class="btn btn-sm btn-outline-primary waves-effect waves-themed w-100"> Shop Comission 
                        <span class="badge  bg-fusion-300 ml-2">
                            <span id="selected_shocks">0 TK</span>
                        </span>
                    </button>
                    <br>
                    <br>
                    
                    <button type="button" class="btn btn-sm btn-outline-success waves-effect waves-themed w-100"> Agent Comission 
                        <span class="badge  bg-fusion-300 ml-2">
                            <span id="selected_shocks">0 TK</span>
                        </span>
                    </button>
                    
                    <br><br>
                    <button type="button" class="btn  btn-sm btn-danger waves-effect waves-themed w-100" disabled >  
                            Sold out confirm & voucher generate
                    </button>
                </div>
            </div>    
        -->       
        </div>
        <br>
            
        <div class="row">
            <div class="col-md-12">
                <div id="panel-2" class="panel">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="accordion accordion-outline" id="m">  
    
                                @foreach($rack_shocks_array as $rack_shocks_size)
                               
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#1" onclick="collapaseShow({{ $rack_shocks_size['type_id'] }})" aria-expanded="true">
                                                
                                                <i class="fal fa-socks width-2 fs-xl"></i>
                                                {{ $rack_shocks_size['name'] }} - ( {{ $rack_shocks_size['total'] }} Pair)
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
                                        <div id="m" class="collapse shocks_collapse_{{ $rack_shocks_size['type_id'] }}" data-parent="#1">
                                            <div class="card-body">
                                                <div class="frame-wrap">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="{{ $rack_shocks_size['type_id'] }}">
                                                        <label class="custom-control-label" onclick="selectAllSocks({{ $rack_shocks_size['type_id'] }})" for="{{ $rack_shocks_size['type_id'] }}">Select All {{ $rack_shocks_size['name'] }} Socks</label>
                                                    </div>

                                                    <hr>

                                                    <div class="demo">
                                                        @foreach($rack_shocks_array[$rack_shocks_size['type_id']]['shocks'] as $size_single_shocks)
                                                            <div class="custom-control custom-checkbox single_checkbox">
                                                                <input type="checkbox" onclick="countTotalSoldoutSocks('{{ $size_single_shocks['shocks_code'] }}')" class="select_items custom-control-input rack_single_shocks_{{  $size_single_shocks['shocks_type_id'] }}" value="{{ $size_single_shocks['shocks_code'] }}" id="{{ $size_single_shocks['shocks_code'] }}">
                                                                <label  class="custom-control-label" for="{{ $size_single_shocks['shocks_code'] }}">{{ $size_single_shocks['shop_socks_code'] ? $size_single_shocks['shop_socks_code'] : $size_single_shocks['print_shocks_code']  }} ({{  $size_single_shocks['brand_name'] }})</label>
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

    

        <input type="hidden" id="calculate_shocks_bill_route" value="{{ route('agent.rack.calculate_shocks_bill') }}">
        <input type="hidden" id="scoks_bill_collect_route" value="{{ route('agent.rack.socks.bill_collect') }}">
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
                console.log(data);              
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
    function voucherGenerateAndSoldOutConfirm(){

        var socks = []
        var checkboxes = document.querySelectorAll('.single_checkbox input[type=checkbox]:checked')

        for (var i = 0; i < checkboxes.length; i++) {
            socks.push(checkboxes[i].value)
        }

        if( socks.length > 0 ){ 
            
            var scoks_bill_collect_route = $("#scoks_bill_collect_route").val();
            var rack_code                = $("#rack_code").val();
            var shop_id                  = $("#shop_id").val();
            var _token                   = $("#_token").val();
            var bill_col_last_day        = $('#bill_col_last_day').val();
           

            const currentDate = new Date();
            var currentDay = currentDate.getDate();

          if(currentDay <=  bill_col_last_day)
          { 
            var agent_sale_date          = $("#agent_sale_date").val();
            var total_bill               = $('#total_bill').val();
            var shop_committion          = $('#shop_committion').val();
            var agent_committion         = $('#agent_committion').val();
            
            if(agent_sale_date ==  '')
            {
                cuteAlert({
                        type: "error",
                        title: "Error",
                        message: "Please Select Socks Sale Date",
                        buttonText: "Try Again"
                    });
                    return false; 
            }

           }else{
            var agent_sale_date = '';
          } 

        cuteAlert({
                type       : "question",
                title      : "Confirmation",
                message    : "Are your sure ? You want to sales selected  socks this " + "<span class='text-danger' > <b> " + agent_sale_date + " </b> </span>",
                confirmText: "Yes",
                cancelText : "No"
            }).then((e)=>{
                if (e == ("confirm")){
                    $.ajax({
                        type: 'POST',
                        url : scoks_bill_collect_route,
                        data: {
                            "shocks"          : socks,
                            "rack_code"       : rack_code,
                            "shop_id"         : shop_id,
                            "_token"          : _token,
                            "agent_sale_date" : agent_sale_date,
                            "total_bill"      : total_bill,
                            "shop_committion" : shop_committion,
                            "agent_committion": agent_committion,
                            "bill_col_last_day" : bill_col_last_day,
                        },
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
                                    //window.location.replace("voucher-download/" + data.bill_no);
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
        }
       
    }
</script>


<script>
    function collapaseShow(id){
        $(".shocks_collapse_"+id).toggleClass("show");
    }
</script>




@endpush
