@extends('layouts.app')
@section('title','Report')

@push('css')
    


<link rel="stylesheet" href="{{ asset('public/backend/assets/dist/themes/default/style.min.css') }}" />

<style type="text/css">
   
   	.jstree-default .jstree-anchor {
		    line-height: 24px;
		    height: 24px;
		    width: 90%;
		}

</style>
@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content p-0">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active"> Balance  Report </li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="subheader"> </div>

    @php 

    function getBalance($acc_no)
    {
    	 $monther_balance = DB::table('gl_accounts')->where('mother_ac_no', $acc_no)->sum('balance');
    	 if(empty($monther_balance))
    	 {
    	 	 $monther_balance = DB::table('gl_accounts')->where('acc_no', $acc_no)->sum('balance');
    	 }else if(!empty($monther_balance)){
    	 	  $monther_balance;
    	 }else{
    	 	  $monther_balance= 0;
    	 }

    	 return $monther_balance;
    }



    @endphp
    

    

   


    <div class="row">
        <div class="col-xl-12 col-md-12">
            <!-- data table -->
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>Balance Report
                        <strong class="ml-sm-2 text-info">

                        </strong>
                    </h2>

                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                            data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                            data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                            data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">

                      

                            <div class="col-md-6">
                                <h2 class="text-center font-weight-bold p-2">ASSET BALANCE LIST</h2>

                                <div id="treeview1" class="treeview">
                                    <ul class="list-group">


                                        <li class="list-group-item node-treeview1 bg-danger text-white" data-nodeid="0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span>GL Name

                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span> Balance

                                                </div>

                                            </div>
                                        </li>


                                      
                                        

                                           <div id="asset">
                                               
                                                


                                                <div id="html" class="demo tree p-2">
                                                    <ul>
                                                         @php 
                                                        $level_one_result = DB::table('gl_accounts')->where([
                                                                                ['gl_level', '=', 1],
                                                                                ['asset_liability_status', '=', 0]
                                                                            ])->get();
                                                        @endphp

                                                        @foreach($level_one_result  as $single_level_one_result)

                                                        <li data-jstree='{ "opened" : true }'> {{ $single_level_one_result->acc_name }}  

                                                        <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_one_result->acc_no) }} </span>

                                                            
                                                            <ul>

                                                                 @php 
                                                                $level_two_result = DB::table('gl_accounts')->where([
                                                                                        ['gl_level', '=', 2],
                                                                                        ['asset_liability_status', '=', 0],
                                                                                        ['mother_ac_no', '=' , $single_level_one_result->acc_no] 
                                            
                                                                                    ])->orwhere([
                                                                                        ['gl_level', '=', 2],
                                                                                        ['asset_liability_status', '=', 0],
                                                                                        ['mother_ac_no', '=' , 0] 
                                                                                        ])->get();
                                                                @endphp

                                                                @foreach($level_two_result as $single_level_two_result)

                                                               

                                                                <li data-jstree='{ "selected" : true }'> 
                                                                    {{ $single_level_two_result->acc_name }} 

                                                                      <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_two_result->acc_no) }} </span>

                                                                    <ul>

                                                                         @php 
                                                                         $level_three_result = DB::table('gl_accounts')->where([
                                                                                ['gl_level', '=', 3],
                                                                                ['asset_liability_status', '=', 0],
                                                                                ['mother_ac_no', '=' , $single_level_two_result->acc_no] 
                                    
                                                                            ])->orwhere([
                                                                                ['gl_level', '=', 3],
                                                                                ['asset_liability_status', '=', 0],
                                                                                ['mother_ac_no', '=' , $single_level_one_result->acc_no] 
                                    
                                                                            ])->get();
                                                                            @endphp

                                                                         @foreach($level_three_result as $single_level_three_result)

                                                                        <li data-jstree='{ "opened" : true }'> 
                                                                            {{ $single_level_three_result->acc_name }}

                                                                               <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_three_result->acc_no) }} </span>

                                                                            <ul>

																			 @php 
																			$level_four_result = DB::table('gl_accounts')->where([
																									['gl_level', '=', 4],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_three_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 4],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_two_result->acc_no] 
														
																								])
																								->orwhere([
																									['gl_level', '=', 4],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_one_result->acc_no] 
														
																								])->get();

																			@endphp
																			@foreach($level_four_result as $single_level_four_result)
																			<li data-jstree='{ "selected" : true }'>
																				{{ $single_level_four_result->acc_name }}

																				   <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_four_result->acc_no) }} </span>

																				<ul>
																					@php 
																					$level_five_result = DB::table('gl_accounts')->where([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_four_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_three_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_two_result->acc_no] 
														
																								])
																								->orwhere([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_one_result->acc_no] 
														
																								])->get();

																					@endphp
																					
																				@foreach($level_five_result as $single_level_five_result)
																					
																					 <li data-jstree='{ "selected" : true }'>
																					 	
																						{{ $single_level_five_result->acc_name }}


																						 <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_five_result->acc_no) }} </span>
																						
																						@php 
																					$level_six_result = DB::table('gl_accounts')->where([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_five_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_four_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_three_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_two_result->acc_no] 
														
																								])
																								->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 0],
																									['mother_ac_no', '=' , $single_level_one_result->acc_no] 
														
																								])->get();

																					@endphp
																						<ul>
																							@foreach($level_six_result as $single_level_six_result)

																							<li data-jstree='{ "selected" : true }'>  
																								{{ $single_level_six_result->acc_name }}

																					 <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_six_result->acc_no) }} </span>
																								
																								<ul> 
																								
																								@php 
																								$level_seven_result = DB::table('gl_accounts')->where([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 0],
																												['mother_ac_no', '=' , $single_level_six_result->acc_no] 
																	
																											])->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 0],
																												['mother_ac_no', '=' , $single_level_five_result->acc_no] 
																	
																											])->where([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 0],
																												['mother_ac_no', '=' , $single_level_four_result->acc_no] 
																	
																											])->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 0],
																												['mother_ac_no', '=' , $single_level_three_result->acc_no] 
																	
																											])->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 0],
																												['mother_ac_no', '=' , $single_level_two_result->acc_no] 
																	
																											])
																											->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 0],
																												['mother_ac_no', '=' , $single_level_one_result->acc_no] 
																	
																											])->get();

																								@endphp
																									
	
																								</ull>
																							</li>
																							@endforeach
																						</ul>
																						
																					 </li>
																				@endforeach
																				</ul>
																				
																			</li>
																			
																		@endforeach

                                                                            </ul>
                                                                        </li>

                                                                        @endforeach
                                                                    </ul>
                                                                </li>

                                                                @endforeach

                                                            </ul>
                                                        </li>

                                                        @endforeach
                                                    </ul>
                                                </div>

                                           </div>



                                        <li class="list-group-item node-treeview1 bg-danger text-white font-weight-bold" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span>

                                                    Total
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                  @php 
                                                   $gnrand_blance  = DB::table('gl_accounts')->where('asset_liability_status', 0)->sum('balance');                                        
                                                    @endphp

                                                     {{ ($gnrand_blance) ? $gnrand_blance: 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
							
							
							 <div class="col-md-6">
                                <h2 class="text-center font-weight-bold p-2">LIABILITY BALANCE LIST</h2>

                                <div id="treeview1" class="treeview">
                                    <ul class="list-group">


                                        <li class="list-group-item node-treeview1 bg-danger text-white" data-nodeid="0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span>GL Name

                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span> Balance

                                                </div>

                                            </div>
                                        </li>


                                      
                                        

                                           <div id="asset">
                                               
                                                



                                                <div id="html" class="demo tree p-2">
                                                    <ul>
                                                         @php 
                                                        $level_one_result = DB::table('gl_accounts')->where([
                                                                                ['gl_level', '=', 1],
                                                                                ['asset_liability_status', '=', 1]
                                                                            ])->get();
                                                        @endphp

                                                        @foreach($level_one_result  as $single_level_one_result)

                                                        <li data-jstree='{ "opened" : true }'> {{ $single_level_one_result->acc_name }} 
<<<<<<< HEAD
<<<<<<< HEAD
                                                        
                                                         @php 
                                                           $gnrand_blance  = DB::table('gl_accounts')->where('asset_liability_status', 1)->sum('balance');
                                                            @endphp
                                                            
                                                            <span class="text-info font-weight-bold" style="float: right;"> {{ $gnrand_blance }} </span>
=======
                                                            
                                                            <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_one_result->acc_no) }} </span>
>>>>>>> 48f93cc56734d3596fe15415ccd7cb35ef8d8d77
=======
                                                            
                                                            <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_one_result->acc_no) }} </span>
>>>>>>> f5637a8a2e693190d55ebcb37c9bb60af5a77d00

                                                            <ul>

                                                                 @php 
                                                                $level_two_result = DB::table('gl_accounts')->where([
                                                                                        ['gl_level', '=', 2],
                                                                                        ['asset_liability_status', '=', 1],
                                                                                        ['mother_ac_no', '=' , $single_level_one_result->acc_no] 
                                            
                                                                                    ])->orwhere([
                                                                                        ['gl_level', '=', 2],
                                                                                        ['asset_liability_status', '=', 1],
                                                                                        ['mother_ac_no', '=' , 0] 
                                                                                        ])->get();
                                                                @endphp

                                                                @foreach($level_two_result as $single_level_two_result)

                                                               

                                                                <li data-jstree='{ "selected" : true }'> 
                                                                    {{ $single_level_two_result->acc_name }} 

                                                                   <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_two_result->acc_no) }} </span>

                                                                    <ul>

                                                                         @php 
                                                                         $level_three_result = DB::table('gl_accounts')->where([
                                                                                ['gl_level', '=', 3],
                                                                                ['asset_liability_status', '=', 1],
                                                                                ['mother_ac_no', '=' , $single_level_two_result->acc_no] 
                                    
                                                                            ])->orwhere([
                                                                                ['gl_level', '=', 3],
                                                                                ['asset_liability_status', '=', 1],
                                                                                ['mother_ac_no', '=' , $single_level_one_result->acc_no] 
                                    
                                                                            ])->get();
                                                                            @endphp

                                                                         @foreach($level_three_result as $single_level_three_result)

                                                                        <li data-jstree='{ "opened" : true }'> 
                                                                            {{ $single_level_three_result->acc_name }}
                                                                            <span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_three_result->acc_no) }} </span>
                                                                            <ul>
<<<<<<< HEAD
<<<<<<< HEAD
                                                                            @php 
=======
>>>>>>> 48f93cc56734d3596fe15415ccd7cb35ef8d8d77
=======
>>>>>>> f5637a8a2e693190d55ebcb37c9bb60af5a77d00
																			$level_four_result = DB::table('gl_accounts')->where([
																									['gl_level', '=', 4],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_three_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 4],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_two_result->acc_no] 
														
																								])
																								->orwhere([
																									['gl_level', '=', 4],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_one_result->acc_no] 
														
																								])->get();

																			@endphp
																			@foreach($level_four_result as $single_level_four_result)
																			<li data-jstree='{ "selected" : true }'>
																				{{ $single_level_four_result->acc_name }}

																				<span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_four_result->acc_no) }} </span>

																				<ul>
																					@php 
																					$level_five_result = DB::table('gl_accounts')->where([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_four_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_three_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_two_result->acc_no] 
														
																								])
																								->orwhere([
																									['gl_level', '=', 5],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_one_result->acc_no] 
														
																								])->get();

																					@endphp
																					
																				@foreach($level_five_result as $single_level_five_result)
																					
																					 <li data-jstree='{ "selected" : true }'>
																						{{ $single_level_five_result->acc_name }}

																						<span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_five_result->acc_no) }} </span>
																						
																						@php 
																					$level_six_result = DB::table('gl_accounts')->where([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_five_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_four_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_three_result->acc_no] 
														
																								])->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_two_result->acc_no] 
														
																								])
																								->orwhere([
																									['gl_level', '=', 6],
																									['asset_liability_status', '=', 1],
																									['mother_ac_no', '=' , $single_level_one_result->acc_no] 
														
																								])->get();

																					@endphp
																						<ul>
																							@foreach($level_six_result as $single_level_six_result)

																							<li data-jstree='{ "selected" : true }'>  
																								{{ $single_level_six_result->acc_name }}

																								<span class="text-info font-weight-bold" style="float: right;"> {{ getBalance($single_level_six_result->acc_no) }} </span>
																								
																								<ul> 
																								
																								@php 
																								$level_seven_result = DB::table('gl_accounts')->where([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 1],
																												['mother_ac_no', '=' , $single_level_six_result->acc_no] 
																	
																											])->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 1],
																												['mother_ac_no', '=' , $single_level_five_result->acc_no] 
																	
																											])->where([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 1],
																												['mother_ac_no', '=' , $single_level_four_result->acc_no] 
																	
																											])->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 1],
																												['mother_ac_no', '=' , $single_level_three_result->acc_no] 
																	
																											])->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 1],
																												['mother_ac_no', '=' , $single_level_two_result->acc_no] 
																	
																											])
																											->orwhere([
																												['gl_level', '=', 7],
																												['asset_liability_status', '=', 1],
																												['mother_ac_no', '=' , $single_level_one_result->acc_no] 
																	
																											])->get();

																								@endphp
																									
	
																								</ull>
																							</li>
																							@endforeach
																						</ul>
																						
																					 </li>
																				@endforeach
																				</ul>
																				
																			</li>
																			
																		@endforeach

                                                                            </ul>
                                                                        </li>

                                                                        @endforeach
                                                                    </ul>
                                                                </li>

                                                                @endforeach

                                                            </ul>
                                                        </li>

                                                        @endforeach
                                                    </ul>
                                                </div>

                                           </div>



                                        <li class="list-group-item node-treeview1 bg-danger text-white font-weight-bold" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span>

                                                    Total
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class=""></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                    @php 
                                                   $gnrand_blance  = DB::table('gl_accounts')->where('asset_liability_status', 1)->sum('balance');
                                                    @endphp
                                                    {{ ($gnrand_blance) ? $gnrand_blance: 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>


                        <!-- ---------------------libility balance ---------------- -->

                       </div>

                    </div>
                </div>
            </div>

            <!-- data table -->
        </div>

    </div>





</main>
@endsection

@push('js')


<script src="{{ asset('public/backend/assets/dist/jstree.min.js') }}"></script>

<script>
    // html demo
    $('.tree').jstree();

    // inline data demo
    $('#data').jstree({
        'core' : {
            'data' : [
                { "text" : "Root node", "children" : [
                        { "text" : "Child node 1" },
                        { "text" : "Child node 2" }
                ]}
            ]
        },
         types: {
            "root": {
              "icon" : "glyphicon glyphicon-plus"
            },
            "child": {
              "icon" : "glyphicon glyphicon-leaf"
            },
            "default" : {
            }
          },
    }).on('open_node.jstree', function (e, data) { data.instance.set_icon(data.node, "glyphicon glyphicon-minus"); 
}).on('close_node.jstree', function (e, data) { data.instance.set_icon(data.node, "glyphicon glyphicon-plus"); });

   
    </script>






@endpush
