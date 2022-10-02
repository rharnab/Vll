@extends('layouts.app')
@section('title','Lot Voucher Create')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Stock </li>
            <li class="breadcrumb-item active">Lot Voucher Create</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Lot Voucher Create Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('stock.lot_voucher.lot_voucher_store') }}" method="post" enctype="multipart/form-data">

                            	@csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Lot No </label>
                                        <input type="text" name="lot_no" id="lot_no" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                              

                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Voucher No</label>
                                            <input type="text" name="voucher_no" id="voucher_no" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>



                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Total Amount</label>
                                            <input type="text" name="total_amt" id="total_amt" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Voucher Image</label>
                                            <input type="file" name="image" id="image" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
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
