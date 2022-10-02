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
                            <form id="" action="{{ route('rack.socks_return.find_socks') }}" method="post" enctype="multipart/form-data">
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
                                                            <td>Brand</td>
                                                            <td>{{ $brand_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Type</td>
                                                            <td>{{ $types_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Size</td>
                                                            <td>{{ $size_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Packet Code</td>
                                                            <td>{{ $style_code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Socks Code</td>
                                                            <td>{{ $socks_code }}</td>
                                                        </tr>														
														<tr>
                                                            <td>Rack Name</td>
                                                            <td>{{ $rack_code }}</td>
                                                        </tr>
														<tr>
                                                            <td>Entry Datetime</td>
                                                            <td>{{ date('jS F,Y h:i a', strtotime($entry_date)) }}</td>
                                                        </tr>
														<tr>
                                                            <td colspan="2">
																<button class="btn btn-sm btn-success btn-block" id="deleteSocksFromRack">Delete</button>
															</td>
                                                        </tr>
                                                        
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </div>
        </div>

		
		@endif


        
        <input type="hidden" id="socks_delete_from_rack_route" value="{{ route('rack.socks_return.delete_socks') }}">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="socks_code" value="{{ $socks_code }}">



    </main>
@endsection

@push('js')
<script>
    $("#deleteSocksFromRack").on('click', function(){
        var rack_level = $("#rack_level").val();
		var socks_code = $("#socks_code").val();

        if( rack_level != ''){
            var socks_delete_from_rack_route = $("#socks_delete_from_rack_route").val();
            var _token                      = $("#_token").val();

            cuteAlert({
                type       : "question",
                title      : "Confirmation",
                message    : "Are your sure ? You want to delete this socks from this rack",
                confirmText: "Yes",
                cancelText : "No"
            }).then((e)=>{
                if (e == ("confirm")){
                    $.ajax({
                        type: 'POST',
                        url : socks_delete_from_rack_route,
                        data: {
                            "socks_code"   : socks_code,
                            "_token"   : _token,
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
                                    location.reload(true);
                                });
                            }else{
                                cuteAlert({
                                    type: "error",
                                    title: "Error",
                                    message: data.message,
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


// 	$("#changeSocksStatus").on('change', function(){
// 		var rack_level = $("#rack_level").val();
// 		var socks_code = $("#socks_code").val();
// 		alert(socks_code);
		
//         if( rack_level != ''){ 
            
//             var product_status_update_route = $("#product_status_update_route").val();
//             var _token                   = $("#_token").val();

//         cuteAlert({
//                 type       : "question",
//                 title      : "Confirmation",
//                 message    : "Are your sure ? You want to change this socks status",
//                 confirmText: "Yes",
//                 cancelText : "No"
//             }).then((e)=>{
//                 if (e == ("confirm")){
//                     $.ajax({
//                         type: 'POST',
//                         url : product_status_update_route,
//                         data: {
//                             "rack_level"   : rack_level,
//                             "socks_code"   : socks_code,
//                             "_token"   : _token,
//                         },
//                         beforeSend: function() {
//                             loaderStart();
//                         },
//                         success: (data) => {
//                             console.log(data);
//                             /*
							if(data.status === 200){
                                cuteAlert({
                                    type      : "success",
                                    title     : "Success",
                                    message   : data.message,
                                    buttonText: "ok"
                                }).then((e)=>{
                                    location.reload(true);
                                });
                            }else{
                                cuteAlert({
                                    type: "error",
                                    title: "Error",
                                    message: data.message,
                                    buttonText: "Try Again"
                                });                                 
                            }   
// */							
//                         },
//                         error: function(data) {
//                             console.log(data);
//                         },
//                         complete: function() {
//                             loaderEnd();
//                         }
//                     });
//                 }
//             })
        
//         });
</script>

@endpush
