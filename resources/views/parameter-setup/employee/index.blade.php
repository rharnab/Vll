@extends('layouts.app')
@section('title','Employee')

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
            <li class="breadcrumb-item active"> Employee </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        <h1 class="subheader-title">            
           

            <span style="float:right">
                <a href="{{route('parameter_setup.employee.create')}}" class="btn btn-sm btn-primary">
                    <span class="fal fa-plus mr-1"></span> Add New
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
                                            Employee List
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
                                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100 text-center">
                                                <thead class="bg-primary-600" style="text-transform: uppercase">
                                                    <tr>

                                                        <th>#SL</th>
                                                        <th>Name</th>
                                                        <th>Designation</th>
                                                        <th>Contact Number</th>
                                                        <th>NID</th>
                                                        <th>Father Name</th>
                                                        <th>Mother Name</th>
                                                        <th>Account No</th>
                                                        <th>Nominee Name</th>
                                                        <th>Present Address</th>
                                                        <th>Image</th>
                                                        <th>Option</th>
                                                       
                                                        
                                                    
                                                    </tr>


                                                </thead>
                                                <tbody>
                                                	

                                                     @php $sl=1; @endphp
                                                    @foreach($employess as $single_info)
                                                    
                                                    <tr>
                                                        <td>{{$sl++}}</td>    
                                                        <td>{{$single_info->name}}</td>    
                                                        <td>{{ ($single_info->designation)? $single_info->designation_name : '-' }}</td>    
                                                        <td>{{ ($single_info->mobile_no)? $single_info->mobile_no : '-'}}</td>    
                                                        <td>{{ ($single_info->nid_no)? $single_info->nid_no: '-' }}</td>    
                                                        <td>{{ ($single_info->father_name)? $single_info->father_name : '-' }}</td>    
                                                        <td>{{ ($single_info->mother_name)? $single_info->mother_name: '-' }}</td>    
                                                        <td>{{ ($single_info->account_no)? $single_info->mother_name: '-' }}</td>    
                                                        <td>{{ ($single_info->nominee_name) ? $single_info->nominee_name : '-' }}</td>    
                                                        <td>{{ ($single_info->present_address) ? $single_info->present_address: '-'}}</td> 

                                                        <td>
                                                            @if(!empty($single_info->employee_img))
                                                            <img src="data:image/png;base64,{{ $single_info->employee_img }}" width="50" height="50" style="border-radius: 50%">

                                                            @else
                                                            <img src="{{ asset('public/backend/assets/img/avatar.png') }}" style="border-radius: 50%" width="50" height="50">
                                                            @endif

                                                        </td>

                                                        <td><a href="{{ route('parameter_setup.employee.edit',Crypt::encrypt($single_info->id )) }}" class="btn btn-info btn-sm">Edit</a></td>
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
    </script>

    <script>
         //tostr message 
         @if(Session::has('message'))
		  toastr.success("{{ session('message') }}");
		  @endif

        //tostr message 
        @if(Session::has('warning'))
		  toastr.warning("{{ session('warning') }}");
		  @endif  
    </script>




@endpush
