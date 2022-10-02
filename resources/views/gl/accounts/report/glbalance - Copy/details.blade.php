@extends('layouts.app')
@section('title','Report')

@push('css')
<style>
.treeview .list-group-item {
    cursor: pointer
}

.treeview span.indent {
    margin-left: 10px;
    margin-right: 10px
}

.treeview span.icon {
    width: 12px;
    margin-right: 5px
}

.treeview .node-disabled {
    color: silver;
    cursor: not-allowed
}

.node-treeview1 {}

.node-treeview1:not(.node-disabled):hover {
    background-color: #F5F5F5;
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
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>GL Name

                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span> Balance

                                                </div>

                                            </div>
                                        </li>


                                        @php 

                    
                                        $level_one_result = DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 1],
                                                                ['asset_liability_status', '=', 0]
                                                            ])->get();


                                        
        
                                        @endphp

                                        @foreach($level_one_result  as $single_level_one_result)
                                        <li class="list-group-item node-treeview1 bg-success text-white" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        {{ $single_level_one_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ ($single_level_one_result->balance)? $single_level_one_result->balance : 0  }}
                                                </div>

                                            </div>
                                        </li>

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


                                        @php

                                        $level_three_chileld =  DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 3],
                                                                ['asset_liability_status', '=', 0],
                                                                ['mother_ac_no', '=' , $single_level_two_result->acc_no] 
                    
                                                            ])->count();
                                        if($level_three_chileld > 1)
                                        {
                                            $class = "bg-success text-white";
                                        }else{
                                            $class = "";
                                        }

                                        @endphp
                                        

                                        <li style="padding-left: 4rem" class="list-group-item node-treeview1 " data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ $single_level_two_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                        {{ ($single_level_two_result->balance) ? $single_level_two_result->balance : 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

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

                                        @php 

                                        $chield_count = DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 4],
                                                                ['asset_liability_status', '=', 0],
                                                                ['mother_ac_no', '=' , $single_level_three_result->acc_no] 
                    
                                                            ])->count();
                                        
                                        if($chield_count > 1)
                                        {
                                            $class = "bg-success text-white";
                                        }else{
                                            $class = "";
                                        }

                                        @endphp



                                        <li style="padding-left: 6rem" class="list-group-item node-treeview1" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ $single_level_three_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                        {{ ($single_level_three_result->balance) ? $single_level_three_result->balance: 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

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

                                        
                                        $chiled_level_four= DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 4],
                                                                ['asset_liability_status', '=', 0],
                                                                ['mother_ac_no', '=' , $single_level_three_result->acc_no] 
                    
                                                            ])->count();
                                        
                                        
                                        

                                        @endphp

                                        @foreach($level_four_result as $single_level_four_result)

                                        <li style="padding-left: 8rem" class="list-group-item node-treeview1 " data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ $single_level_four_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                        {{ ($single_level_four_result->balance) ? $single_level_four_result->balance : 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

                                        @endforeach
                                        @endforeach
                                        @endforeach
                                        @endforeach

                                        @php
                                            $total_balance = DB::table('gl_accounts')->where('asset_liability_status', 0)->sum('balance');
                                        @endphp


                                        <li class="list-group-item node-treeview1 bg-danger text-white font-weight-bold" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                    Total
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                    {{ $total_balance  }}
                                                    
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
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>GL Name

                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span> Balance

                                                </div>

                                            </div>
                                        </li>


                                        @php 

                    
                                        $level_one_result = DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 1],
                                                                ['asset_liability_status', '=', 1]
                                                            ])->get();


                                        
        
                                        @endphp

                                        @foreach($level_one_result  as $single_level_one_result)
                                        <li class="list-group-item node-treeview1 bg-success text-white" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        {{ $single_level_one_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ ($single_level_one_result->balance)? $single_level_one_result->balance : 0 }}
                                                </div>

                                            </div>
                                        </li>

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


                                        @php

                                        $level_three_chileld =  DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 3],
                                                                ['asset_liability_status', '=', 1],
                                                                ['mother_ac_no', '=' , $single_level_two_result->acc_no] 
                    
                                                            ])->count();
                                        if($level_three_chileld > 1)
                                        {
                                            $class = "bg-success text-white";
                                        }else{
                                            $class = "";
                                        }

                                        @endphp
                                        

                                        <li style="padding-left: 4rem" class="list-group-item node-treeview1" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ $single_level_two_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                        {{ ($single_level_two_result->balance)? $single_level_two_result->balance: 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

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

                                        @php 

                                        $chield_count = DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 4],
                                                                ['asset_liability_status', '=', 1],
                                                                ['mother_ac_no', '=' , $single_level_three_result->acc_no] 
                    
                                                            ])->count();
                                        
                                        if($chield_count > 1)
                                        {
                                            $class = "bg-success text-white";
                                        }else{
                                            $class = "";
                                        }

                                        @endphp



                                        <li style="padding-left: 6rem" class="list-group-item node-treeview1" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ $single_level_three_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                        {{ ($single_level_three_result->balance)? $single_level_three_result->balance : 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

                                        @php 
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

                                        
                                        $chiled_level_four= DB::table('gl_accounts')->where([
                                                                ['gl_level', '=', 4],
                                                                ['asset_liability_status', '=', 1],
                                                                ['mother_ac_no', '=' , $single_level_three_result->acc_no] 
                    
                                                            ])->count();
                                        
                                        
                                        

                                        @endphp

                                        @foreach($level_four_result as $single_level_four_result)

                                        <li style="padding-left: 9rem" class="list-group-item node-treeview1 " data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                        {{ $single_level_four_result->acc_name }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                        {{ ($single_level_four_result->balance)? $single_level_four_result->balance: 0 }}
                                                    
                                                </div>

                                            </div>
                                        </li>

                                        @endforeach
                                        @endforeach
                                        @endforeach
                                        @endforeach

                                        @php
                                            $total_balance = DB::table('gl_accounts')->where('asset_liability_status', 1)->sum('balance');
                                        @endphp


                                        <li class="list-group-item node-treeview1 bg-danger text-white font-weight-bold" data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>

                                                    Total
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span
                                                        class="icon expand-icon glyphicon glyphicon-plus"></span><span
                                                        class="icon node-icon"></span>
                                                        
                                                    {{ $total_balance  }}
                                                    
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






@endpush