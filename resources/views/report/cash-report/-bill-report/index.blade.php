@extends('layouts.app')
@section('title','Cash Report')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item">Cash Report</li>
            <li class="breadcrumb-item active">Bill Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Bill Summary Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('report.cash_report.bill-info') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Status</label>
                                        <select class="form-control select2" name="status" required>
                                            <option value="1">Due Bill</option>
                                            <option value="3">Agent Cash</option>
                                            <option value="7">Receive Cash</option>
                                           
                                              
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Shop</label>
                                        <select class="form-control select2" name="shop_id" required>
                                            <option value="0">All</option>
                                            @foreach($all_shops as $single_shop)
                                            <option value="{{ $single_shop->shop_id }}">{{ $single_shop->shop_name }}</option>
                                            @endforeach
                                           
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Agent</label>
                                        <select class="form-control select2" name="agent_id" required>
                                            <option value="0">All</option>
                                            @foreach($all_agent as $single_agent)
                                            <option value="{{ $single_agent->agent_id }}">{{ $single_agent->agen_name }}</option>
                                            @endforeach
                                           
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Start Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="frm_date" required>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">End Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="to_date" required>
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
