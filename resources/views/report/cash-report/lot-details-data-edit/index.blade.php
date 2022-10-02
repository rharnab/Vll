@extends('layouts.app')
@section('title','Lot Details Data Edit')

@push('css')


@endpush
@section('content')

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item">Cash Report</li>
            <li class="breadcrumb-item active">Lot Details Data Edit</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Lot Details Data Edit</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ url('report/cash-report/lot-details-data-update') }}" method="post" enctype="multipart/form-data" >

                                @csrf

                                <input type="hidden" value="{{$get_data->lot_no}}" name="hidden_lot_id">
                                <input type="hidden" value="{{$get_data->product_id}}" name="hidden_product_id">
                                <input type="hidden" value="{{$get_data->type_id}}" name="hidden_type_id">
                                <input type="hidden" value="{{$get_data->cat_id}}" name="hidden_cat_id">

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Brand Name</label>
                                        <input type="text" class="form-control" readonly name="brand_name" value="{{$get_data->brand_name}}">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>

                               


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Types Name</label>
                                        <input type="text" class="form-control" readonly name="types_name" value="{{$get_data->types_name}}">
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Size</label>
                                        <input type="text" class="form-control" readonly name="size" value="{{$get_data->size_name}}">
                                        
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Total Packet</label>
                                        <input type="text" class="form-control" readonly name="total_packet" value="{{$get_data->total_packet}}">
                                        
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Per Packet Socks</label>
                                        <input type="text" class="form-control" readonly name="per_packet_socks" value="{{$get_data->per_packet_shocks_quantity}}">
                                        
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Total Socks dozens</label>
                                        <input type="text" class="form-control" readonly name="total_socks" value="{{$get_data->total_shocks / 12 }}">
                                        
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                               
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Packet DP Price</label>
                                        <input type="text" class="form-control"  name="packet_dp_price" value="{{$get_data->packet_buy_price}}">
                                        
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Packet TP Price</label>
                                        <input type="text" class="form-control"   name="packet_tp_price" value="{{$get_data->packet_sale_price}}">
                                        
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                

                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">Update</button>
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
@endpush
