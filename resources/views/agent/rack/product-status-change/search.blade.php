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
            <li class="breadcrumb-item">Product Status Change</li>
            <li class="breadcrumb-item active"> Product Status Change </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Single Socks Result</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <form id="" action="{{ route('agent.rack.product_status_change.find_product') }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Socks Code</label>
                                        <input type="text" name="socks_code" id="socks_code" value="{{ $socks_code }}" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                </div>                               
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">Find Socks</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		
		@if($found === false)
					 <div class="row">
            <div class="col-xl-6 col-md-6 ">
               <div id="panel-7" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
										{{ $socks_code }} Socks Information
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                               Shocks Not Found Any Rack
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </div>
        </div>

		
		@else 
					 <div class="row">
            <div class="col-xl-6 col-md-6 ">
               <div id="panel-7" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
										{{ $socks_code }} Socks Information
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                               Shocks Find out successfully
                                            </div>
                                            <div class="frame-wrap">
                                                <table class="table table-sm table-bordered m-0">
                                                    <thead class="bg-primary-500">
                                                        <tr>
                                                            <th>Field Name</th>
                                                            <th>Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Socks Code</td>
                                                            <td>{{ $socks_code }}</td>
                                                        </tr>
														 <tr>
                                                            <td>Shop Name</td>
                                                            <td>{{ $shop_name }}</td>
                                                        </tr>
														<tr>
                                                            <td>Agent Name</td>
                                                            <td>{{ $agent_name }}</td>
                                                        </tr>
														<tr>
                                                            <td>Rack Name</td>
                                                            <td>{{ $rack_code }}</td>
                                                        </tr>
														<tr>
                                                            <td>Current Status</td>
                                                            <td class="text-primary font-bold">
																{{ $status }}	
															</td>
                                                        </tr>
														<tr>
                                                            <td>Entry Datetime</td>
                                                            <td>{{ date('jS F,Y h:i a', strtotime($entry_date)) }}</td>
                                                        </tr>
														
														<tr>
                                                            <td>Change Status</td>
                                                            <td>
																<div class="form-row">
																  <div class="col-md-12 mb-3">																		
																		<select class="form-control select2" name="rack_level" id="rack_level" required>
																			<option value="">--Select Change Status--</option>
																			<option value="0">Rack Fillup</option>
																			<option value="2">Rack Re-Fillup</option>
																			<option value="1">Shopkepper Sales</option>
																			<option value="3">Agent Bill Collect</option>
																		</select>
																	</div>                                    
																</div>
															</td>
                                                        </tr>
														<tr>
                                                            <td colspan="2">
																<button class="btn btn-sm btn-success btn-block" id="changeSocksStatus">Change Status</button>
															</td>
                                                        </tr>

                                                        <input type="hidden" id="rack_product_id" value="{{ $rack_product_id }}">
                                                        
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </div>
        </div>

		
		@endif


        
        <input type="hidden" id="product_status_update_route" value="{{ route('agent.rack.product_status_change.status_update') }}">
        <input type="hidden" id="reload_route" value="{{ route('agent.rack.product_status_change.index') }}">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="socks_code" value="{{ $socks_code }}">



    </main>
@endsection

@push('js')
<script>
    $("#changeSocksStatus").on('click', function(){
        var rack_level = $("#rack_level").val();
		var socks_code = $("#socks_code").val();

        if( rack_level != ''){
            var product_status_update_route = $("#product_status_update_route").val();
            var reload_route                = $("#reload_route").val();
            var _token                      = $("#_token").val();
            var rack_product_id             = $("#rack_product_id").val();

            cuteAlert({
                type       : "question",
                title      : "Confirmation",
                message    : "Are your sure ? You want to change this socks status",
                confirmText: "Yes",
                cancelText : "No"
            }).then((e)=>{
                if (e == ("confirm")){
                    $.ajax({
                        type: 'POST',
                        url : product_status_update_route,
                        data: {
                            "rack_level"     : rack_level,
                            "socks_code"     : socks_code,
                            "rack_product_id": rack_product_id,
                            "_token"         : _token,
                        },
                        beforeSend: function() {
                            loaderStart();
                        },
                        success: (data) => {
                            if(data.status === 200){
                                cuteAlert({
                                    type      : "success",
                                    title     : "Success",
                                    message   : data.message,
                                    buttonText: "ok"
                                }).then((e)=>{
                                    window.location.replace(reload_route);
                                });
                            }else{
                                cuteAlert({
                                    type      : "error",
                                    title     : "Error",
                                    message   : data.message,
                                    buttonText: "Try Again"
                                });                                 
                            } 				
                        },
                        error: function(data) {
                          
                        },
                        complete: function() {
                            loaderEnd();
                        }
                    });
                }
            })

        }
    });

</script>

@endpush
