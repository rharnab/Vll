@extends('layouts.app')
@section('title','Report')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/backend/assets/multiselect/css/bootstrap-multiselect.css')}}" type="text/css">
@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item"> Report</li>
            <li class="breadcrumb-item active">User Wise Summation Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>User Wise Summation Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form  action="{{ route('report.user_wise_summation.generate') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Shop</label>
                                        <select class="form-control select2" onchange="get_shop_id(this.value)" name="shop_id" required>
                                           <option value="all">ALL</option>
                                           @foreach($shops as $shop)
                                                <option value="{{$shop->id}}">{{$shop->name}}</option>
                                           @endforeach
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>                                
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select User</label>
                                        <select multiple="multiple" class="form-control multiple_select" placeholder="Please Select Branch" name="user[]">
                                            <option value="0">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->role_name }}</option>
                                            @endforeach
									    </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>                                
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Status</label>
                                        <select class="form-control select2" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="0">Not Sold</option>
                                            <option value="1">Shop Keeper Sold</option>
                                            <option value="2">Refill</option>
                                            <option value="3">Agent Cash</option>
                                            <option value="5">Return</option>
                                            <option value="7">Bill Authorize</option>
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                                <div class="form-row">
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
    <script type="text/javascript" src="{{ asset('public/backend/assets/multiselect/js/bootstrap-multiselect.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            $('.multiple_select').multipleSelect({
                filter: true,
                filterPlaceholder: 'Search Here',
                animate: 'slide',
            })
        })
    </script>
@endpush