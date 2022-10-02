@extends('layouts.app')
@section('title','Rack-Fillup')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Rack Socks</li>
            <li class="breadcrumb-item active"> Socks Return Voucher </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Generate Socks Return Voucher</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <form id="socks_return_from_rack" action="{{ route('rack.socks_return.generate_socks_return_voucher') }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Rack Code</label>
                                        <select class="form-control select2" name="rack_code" id="rack_code" required>
                                            <option value="">Select Rack</option>
                                            @foreach($get_rack as $rack)
                                                <option value="{{ $rack->rack_code }}"> {{ $rack->rack_code }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div> 


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Starting Date</label>
                                       <input type="date" name="starting_date" class="form-control">
                                    </div>
                                </div> 


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Ending Date</label>
                                       <input type="date" name="ending_date" class="form-control">
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

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="find_socks_list" value="{{ route('rack.socks_return.find_socks_list') }}">
        <input type="hidden" id="delete_socks_route" value="{{ route('rack.socks_return.delete_socks') }}">
    </main>
@endsection

@push('js')


@endpush
