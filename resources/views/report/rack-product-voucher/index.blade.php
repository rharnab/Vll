@extends('layouts.app')
@section('title','Report')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item"> Report</li>
            <li class="breadcrumb-item active">Rack  Product Voucher</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Status Wise Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('report.Rack.product.details') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Rack</label>
                                        <select class="form-control select2"  name="rack_code" required>
                                           <option value="">--select--</option>
                                           @foreach($all_rack as $single_rack)
                                                <option value="{{ $single_rack->rack_code }}">{{ $single_rack->rack_code }}</option>
                                           @endforeach
                                          
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                {{-- <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Starting Date</label>
                                        <input type="date" class="form-control" name="starting_date">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Ending Date</label>
                                        <input type="date" class="form-control" name="ending_date">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div> --}}

                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">Generate</button>
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
        function get_shop_id(shop_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
                
            });

            var formData = {
                    shop_id:shop_id
                            
                        };

            $.ajax({
                type: 'POST',
                url: "{{ url('report/get-shop-id') }}",
                data: formData,

                beforeSend: function() {
                jQuery(".loader").show();
                },

                success: function(data) {
                    
                   
                    $(".select_rack").html(data);
                

                },
                error: function(response) {

                        
                    cuteAlert({
                    type: "warning",
                    title: "Data Not Found !",
                    message: "",
                    buttonText: "Okay",
                    timer: 10000
                    })

                },

                complete: function() {

                    jQuery(".loader").hide();
                }

            });

        }
    </script>
@endpush
