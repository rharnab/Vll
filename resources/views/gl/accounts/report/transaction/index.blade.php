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
            <li class="breadcrumb-item active">GL Transaction Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>GL Transaction Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('account.report.gl_transaction.generate') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf

                                <div class="col-md-12 mb-3 select_2_error">
                                    <label class="form-label" for="account_name"> Select Primary Account</label>                                        
                                    <select class="form-control select2" name="account_no" id="account_no"  required>
                                        <option value="all">All Account</option>
                                        @foreach($accounts as $account)
                                           {{--  <option value="{{ $account->acc_no }}"> {{ $account->acc_name }} ({{ $account->acc_no }})</option> --}}
                                            <option value="{{ $account->acc_no }}"> {{ $account->acc_name }} (

                                                @if($account->asset_liability_status == 0)
                                                    {{ "Asset" }}
                                                @elseif($account->asset_liability_status == 1)
                                                    {{ "Liability" }}
                                                @else
                                                    {{ "" }}
                                                @endif
                                            ) </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                    </div>
                                </div>



                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Start Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="frm_date">
                                        <div class="valid-feedback">
                                        </div>
                                    </div>                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">End Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="to_date">
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
