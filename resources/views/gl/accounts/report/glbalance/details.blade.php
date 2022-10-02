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
        <li class="breadcrumb-item active"> Balance Report </li>
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
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span>GL Name

                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span> Balance

                                                </div>

                                            </div>
                                        </li>





                                        <div id="asset">




                                            <div id="html" class="demo tree p-2">
                                                <ul>

                                                    @foreach($assets_gl_list['root_gl'] as $asset_root_gl)
                                                        <li data-jstree='{ "opened" : true }'>
                                                            {{ $asset_root_gl['account_name'] }}
                                                            <span class="text-info font-weight-bold" style="float: right;">{{ number_format($asset_root_gl['balance'],2) }} TK</span>

                                                            @if(count($asset_root_gl['second_level_gl']) > 0)
                                                                @foreach($asset_root_gl['second_level_gl'] as $asset_second_gl)
                                                                    <ul>
                                                                        <li data-jstree='{ "opened" : true }'>
                                                                            {{ $asset_second_gl['account_name'] }}
                                                                            <span class="text-info font-weight-bold" style="float: right;">{{ number_format($asset_second_gl['balance'],2) }} TK</span>

                                                                            @if(count($asset_second_gl['third_level_gl']) >0)
                                                                                @foreach($asset_second_gl['third_level_gl'] as $third_level_gl)
                                                                                    <ul>
                                                                                        <li data-jstree='{ "opened" : true }'>
                                                                                            {{ $third_level_gl['account_name'] }}
                                                                                            <span class="text-info font-weight-bold" style="float: right;">{{ number_format($third_level_gl['balance'],2) }} TK</span>
                                                                                        </li>
                                                                                    </ul>
                                                                                @endforeach
                                                                            @endif
                                                                        </li>
                                                                    </ul>                                                                    
                                                                @endforeach
                                                            @endif
                                                        </li>
                                                    @endforeach   
                                                </ul>
                                            </div>

                                        </div>



                                        <li class="list-group-item node-treeview1 bg-danger text-white font-weight-bold"
                                            data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span>

                                                    Total
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span>
                                                        {{ number_format($total_asset_gl_balance,2) }} TK
                                                  
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
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span>GL Name

                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span> Balance

                                                </div>

                                            </div>
                                        </li>





                                        <div id="asset">




                                            <div id="html" class="demo tree p-2">
                                                <ul>

                                                    @foreach($liability_gl_list['root_gl'] as $liability_root_gl)
                                                        <li data-jstree='{ "opened" : true }'>
                                                            {{ $liability_root_gl['account_name'] }}
                                                            <span class="text-info font-weight-bold" style="float: right;">{{ number_format($liability_root_gl['balance'],2) }} TK</span>

                                                            @if(count($liability_root_gl['second_level_gl']) > 0)
                                                                @foreach($liability_root_gl['second_level_gl'] as $liability_second_gl)
                                                                    <ul>
                                                                        <li data-jstree='{ "opened" : true }'>
                                                                            {{ $liability_second_gl['account_name'] }}
                                                                            <span class="text-info font-weight-bold" style="float: right;">{{ number_format($liability_second_gl['balance'],2) }} TK</span>

                                                                            @if(count($liability_second_gl['third_level_gl']) >0)
                                                                                @foreach($liability_second_gl['third_level_gl'] as $liability_third_level_gl)
                                                                                    <ul>
                                                                                        <li data-jstree='{ "opened" : true }'>
                                                                                            {{ $liability_third_level_gl['account_name'] }}
                                                                                            <span class="text-info font-weight-bold" style="float: right;">{{ number_format($liability_third_level_gl['balance'],2) }} TK</span>
                                                                                        </li>
                                                                                    </ul>
                                                                                @endforeach
                                                                            @endif
                                                                        </li>
                                                                    </ul>                                                                    
                                                                @endforeach
                                                            @endif
                                                        </li>
                                                    @endforeach   
                                                </ul>
                                            </div>

                                        </div>



                                        <li class="list-group-item node-treeview1 bg-danger text-white font-weight-bold"
                                            data-nodeid="1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span>

                                                    Total
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <span class="indent"></span><span class=""></span><span
                                                        class="icon node-icon"></span>
                                                        {{ number_format($total_liability_gl_balance,2) }} TK
                                                  
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



</main>
@endsection

@push('js')


<script src="{{ asset('public/backend/assets/dist/jstree.min.js') }}"></script>

<script>
// html demo
$('.tree').jstree();

// inline data demo
$('#data').jstree({
    'core': {
        'data': [{
            "text": "Root node",
            "children": [{
                    "text": "Child node 1"
                },
                {
                    "text": "Child node 2"
                }
            ]
        }]
    },
    types: {
        "root": {
            "icon": "glyphicon glyphicon-plus"
        },
        "child": {
            "icon": "glyphicon glyphicon-leaf"
        },
        "default": {}
    },
}).on('open_node.jstree', function(e, data) {
    data.instance.set_icon(data.node, "glyphicon glyphicon-minus");
}).on('close_node.jstree', function(e, data) {
    data.instance.set_icon(data.node, "glyphicon glyphicon-plus");
});
</script>






@endpush