@extends('layouts.app')
@section('title','Agent Report')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active"> Agent Tag Report </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                     <h2> Shop Report </h2>

                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                            <!-- datatable start -->
                                            <table class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                       <th>#Sl</th>
                                                       <th>Agent Name</th>
                                                       <th>Mobile Number</th>
                                                       <th>Address</th>
                                                       <th>Email</th>
                                                       <th>Total Registered Shop</th>
                                                       <th>Details</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                	@endphp
                                                    @foreach($agent_result as $single_result)
                                                    <tr>
                                                        <td>{{ $sl++ }}</td>
                                                        <td>{{ $single_result->agent_name }}</td>
                                                        <td>{{ $single_result->mobile_number }}</td>
                                                        <td>{{ $single_result->present_address }}</td>
                                                        <td>{{ $single_result->email }}</td>
                                                        <td>{{ $single_result->total_shop }}</td>
                                                        <td><button class="btn btn-primary btn-sm" onclick=ShopDetails({{$single_result->agent_id}})>Details</button></td>
                                                    </tr>
                                                    @endforeach
                                                	
                                                	
                                                	                                                   
                                                </tbody>
                                            </table>
                                            <!-- datatable end -->
                                        </div>
                                    </div>
                                </div>

                <!-- data table -->
            </div>

        </div>

{{-- ---------bootstrap modal ---------------------}}

<div id="shopDetails" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shop Details [ <span class="agent_name  text-danger font-weight-bold"> </span> ] </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="show_result">
                
                
            </div>
        
        </div>
    </div>
    </div>
    {{-- ---------bootstrap modal ---------------------}}
        




    </main>
@endsection

@push('js')

 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>


 <script>
     function ShopDetails(agent_id)
    {
        
        $('#LotDetails').modal('show');
        if(agent_id != '')
        {
            $.ajax({
                type:'POST',
                url: "{{ route('report.agent.shop_details') }}",
                data:{ "agent_id": agent_id,  "_token": '{{ csrf_token()}}'},
                beforeSend: function()
                {
                    loaderStart();
                },
                success:function(data)
                {
                    var agent_name = $('#agent_name').val();
                    
                    $('#show_result').html(data);
                    $('.agent_name').html(agent_name)
                    $('#shopDetails').modal('show');
                    //console.log(data);
                    dataTableWithBUtton();

                },
                complete:function()
                {
                    loaderEnd();
                }

            });
        }
    }

        
</script>


<script>
    /*data table script*/

     $(document).ready(function()
            {
                dataTableWithBUtton();

            });
    </script>

    <script>
        function dataTableWithBUtton()
        {

            
               // initialize datatable
               $('.dataTable').dataTable(
                {
                    responsive: true,
                    "pageLength": 50,

                      dom:
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            titleAttr: 'Generate PDF',
                            className: 'btn-outline-danger btn-sm mr-1'
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-success btn-sm mr-1'
                        },
                       
                        
                        
                    ]

                });

        }
    </script>



@endpush