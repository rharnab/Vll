@extends('layouts.app')
@section('title','Report')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active">Rack Product Details Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Rack Product Details Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('report.Rack-product.details') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf


                                <div class="form-row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Rack Code</label>
                                        <select class="form-control select2" name="rack_code" required>
                                            <option value="">--select--</option>
                                               @foreach($racks as $single_rack_info)

                                               <option value="{{$single_rack_info->rack_code}}">{{$single_rack_info->rack_code}}</option>

                                               @endforeach
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Status</label>
                                        <select class="form-control select2" name="rack_status">
                                            <option value="">All</option>
                                            <option value="0">New</option>
                                            <option value="1">Sold</option>
                                            <option value="2">Refill</option>
                                            <option value="3">Agent Cash</option>
                                            <option value="5">Return</option>
                                            <option value="7">Cash Receive</option>
                                            <option value="8">Unsold</option>
                                              
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                
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
