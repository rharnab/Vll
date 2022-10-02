@extends('layouts.app')
@section('title','Due Bill')

@push('css')

 


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item">Due Bill Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>


        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                          <h2>Due Bill Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="commission_form"  method="post" enctype="multipart/form-data" action="{{ route('report.bill.due.details') }}">

                                @csrf

                               

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Shop </label>
                                        
                                        <select class="form-control select2" name="rack_code" id="rack_code"  required>
                                           <option value="">Select Shop</option>

                                           @foreach($all_due_shop as $single_shop)

                                              <option value="{{ $single_shop->rack_code }}">{{ $single_shop->shop_name }}</option>

                                           @endforeach
                                          
                                           
                                            
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>
                               
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">Details</button>
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

<script type="text/javascript">

</script>





@endpush
