@extends('layouts.app')
@section('title','Lot Voucher')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/assets/css/notifications/toastr/toastr.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Stock</li>
            <li class="breadcrumb-item active"> Lot Voucher </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        <h1 class="subheader-title">            
           

            <span style="float:right">
                <a href="{{route('stock.lot_voucher.create')}}" class="btn btn-sm btn-primary">
                    <span class="fal fa-plus mr-1"></span> Add 
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
                                           Lot Voucher
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
                                                        <th>Lot-No</th>
                                                        <th>Voucher No</th>
                                                        <th>Total amount</th>
                                                        <th>Voucher Image</th>
                                                        <th>Status </th>
                                                       <!--  <th>Entry By</th>

                                                        <th>Entry Date Time</th>
                                                        <th>Authorized By</th>
                                                        <th>Authorized Date Time</th> -->
                                                        <th>Authorized Percentage</th>
                                                      <!--   <th>Action</th> -->
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php  $sl=1;  @endphp
                                                   @foreach($data as $single_data) 

                                                    	<tr>
                                                            <td>{{$sl++}}</td>
                                                             <td>{{$single_data->lot_no}}</td>  
                                                             <td>{{$single_data->voucher_no}}</td>  
                                                             <td>{{$single_data->total_amt}}</td>  

                                                             <td><img src="{{asset('uploads/lot_voucher_image/')}}/{{$single_data->image}}" width="50" height="50"></td>  

                                                             <td>
                                                                <?php 

                                                                 $status = $single_data->status;

                                                                 if($status=='0') {
                                                                     echo "<span class='text-danger'>Unauthorized </span>";

                                                                 }elseif ($status=='1') {

                                                                      echo "<span class='text-primary'>Authorized </span>";
                                                                 }

                                                               ?></td>  
                                                           <!--   <td>{{$single_data->entry_by}}</td>  
                                                             <td>{{$single_data->entry_datetime}}</td>  
                                                             <td>{{$single_data->authorized_by}}</td>  
                                                             <td>{{$single_data->authorized_datetime}}</td>   -->
                                                             <td>{{$single_data->authorized_percentage}}</td>  
                                                            <!--  <td><button class="btn btn-primary btn-sm">Authorize</button></td> -->
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


       //tostr message 
         @if(Session::has('message'))
          toastr.success("{{ session('message') }}");
          @endif
    </script>




@endpush