@extends('layouts.app')
@section('title','Agent  Report')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active">Agent Commission Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Agent Commission Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('report.agent.commission.shop_list') }}" method="post" enctype="multipart/form-data" target="_blank">

                                @csrf

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Agent</label>
                                       
                                        <select name="agent_id" id="agent_id" class="form-control select2"  required>
                                            @if(Auth::user()->role_id != 2 )
                                            <option value="0">All</option>
                                            @else
                                            <option value="">Select Agent</option>
                                            @endif
                                            
                                            @foreach($all_agents as $single_agent)
                                            <option value="{{ $single_agent->agent_id }}">{{ $single_agent->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="shop">Select Shop</label>
                                       
                                        <select name="shop_id" id="shop_id" class="form-control select2"  required>
                                            <option value="0">All</option>
                                           
                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                               

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Start Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="frm_date" >
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">End Date</label>
                                        <input type="date" class="form-control" plceholder="Start Date" name="to_date" >
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

    <script>
        $('#agent_id').on('change', function(){
            var agent_id = $("#agent_id").val();
           
            if(agent_id !='')
            {
                $.ajax({
                    type:"POST",
                    url:"{{ route('report.agent.commission.agent_shop_list') }}",
                    data:{
                        agent_id: agent_id,
                        "_token": " {{ csrf_token() }} ",
                    },
                    success:function(data)
                    {
                        $("#shop_id").empty().append(data);
                        
                    }
                })
            }
        })
    </script>




    <script>
        $(function() {

             var $form = $(this);

            $.validator.setDefaults({
                errorClass: 'help-block',
                highlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .removeClass('has-error');
                }
            });

        });
    </script>
@endpush
