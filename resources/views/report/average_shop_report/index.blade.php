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
            <li class="breadcrumb-item active">Average shop Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Average shop Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('report.average.show') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Product </label>
                                        <select class="form-control select2"  name="product_id" >
                                          <option value="">Select Product</option>
                                          @foreach($products as $single_product)
                                            <option value="{{ $single_product->product_id }}">{{ $single_product->brand_name }} - {{ $single_product->brand_size_name }} - {{ $single_product->types_name }} [ {{ $single_product->packet_socks_pair_quantity }} ] </option>
                                          @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Type </label>
                                        <select class="form-control select2"  name="type_id" >
                                          <option value="">Select Type</option>
                                          @foreach($types as $single_type)
                                            <option value="{{ $single_type->id }}"> {{ $single_type->types_name }} </option>
                                          @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Size </label>
                                        <select class="form-control select2"  name="size_id" >
                                          <option value="">Select Size </option>
                                          @foreach($brand_size as $single_brand_size)
                                            <option value="{{ $single_brand_size->id }}"> {{ $single_brand_size->name }} </option>
                                          @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Shop</label>
                                        <select class="form-control select2"  name="shop_id" >
                                          <option value="">Select shop</option>

                                          @foreach($shops as $single_shop)
                                                <option value="{{ $single_shop->id }}">{{ $single_shop->name }}</option>

                                          @endforeach
                                          

                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>


                               
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Start Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="starting_date" required>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">End Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="ending_date" required>
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
   
@endpush
