@extends('layouts.app')
@section('title','Agent-User')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/assets/css/notifications/toastr/toastr.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter Setup</li>
            <li class="breadcrumb-item active"> Agent User List </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        <h1 class="subheader-title">            
           

            <span style="float:right">
                <a href="{{route('parameter_setup.agent.create')}}" class="btn btn-sm btn-primary">
                    <span class="fal fa-plus mr-1"></span> Add New Agent
                </a>
            </span>
            
        </h1>
    </div>

        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Agent User List
                                        </h2>

                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                            <!-- datatable start -->
                                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100">
                                                <thead class="bg-primary-600">
                                                    <tr>

                                                        <th>#SL</th>
                                                        <th>Image</th>
                                                        <th>NID Image</th>
                                                        <th>Name</th>
                                                        <th> NID Number </th>
                                                        <th> Mobile Number </th>
                                                        <th>Present Address</th>
                                                        <th>Permanent Address</th>                                                       
                                                        <th>Email</th>
                                                        <th>Action</th>
                                                        
                                                    
                                                    </tr>


                                                </thead>
                                                <tbody>
                                                    @php $sl=1; @endphp
                                                    @foreach($get_data as $single_info)                                                    
                                                    <tr>
                                                        <td>{{$sl++}}</td>    
                                                        <td>
                                                            @if(!empty($single_info->image))
                                                                <img src="{{ asset('uploads/agent_user_image')}}/{{$single_info->image}}" style="border-radius: 50%" width="50" height="50">
                                                            @else 
                                                                <img src="{{ asset('public/backend/assets/img/avatar.png') }}" style="border-radius: 50%" width="50" height="50">
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if(!empty($single_info->nid_image))
                                                                <img src="{{ asset('uploads/agent_user_nid')}}/{{$single_info->nid_image}}" style="border-radius: 50%" width="50" height="50">
                                                            @else 
                                                                <img src="{{ asset('public/backend/assets/img/avatar.png') }}" style="border-radius: 50%" width="50" height="50">
                                                            @endif
                                                        </td>

                                                        <td>{{$single_info->name}}</td>    
                                                        <td>{{$single_info->nid_number}}</td>    
                                                        <td>{{$single_info->mobile_number}}</td>    
                                                        <td>{{$single_info->present_address}}</td>    
                                                        <td>{{$single_info->permanent_address}}</td>    
                                                       
                                                        <td>{{$single_info->email}}</td>    
                                                        <td><a href="{{url('parameter-setup/agent/edit-agent/')}}/{{$single_info->id}}" class="btn btn-info btn-sm">Edit</a></td>    
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


        




    </main>
@endsection

@push('js')

 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>
  <script src="{{ asset('public/backend/assets/js/notifications/toastr/toastr.js') }}"></script>

    <script>

    /*data table script*/

     $(document).ready(function()
            {

                // initialize datatable
                $('#dt-basic-example').dataTable(
                {
                    responsive: true,
                    lengthChange: false,
                    dom:
                        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        /*{
                            extend:    'colvis',
                            text:      'Column Visibility',
                            titleAttr: 'Col visibility',
                            className: 'mr-sm-3'
                        },*/
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
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'copyHtml5',
                            text: 'Copy',
                            titleAttr: 'Copy to clipboard',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm'
                        }
                    ]
                });

            });

    /*data table script*/




        //tostr message 
         @if(Session::has('message'))
		  toastr.success("{{ session('message') }}");
		  @endif
    </script>




@endpush
