@extends('layouts.app')
@section('title',' Authorize Factory Bill')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Bill Collection</li>
            <li class="breadcrumb-item active"> Authorize Factory Bill </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>


        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Authorize Factory Bill
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
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>#SL</th>
                                                        <th>Client Name </th>
                                                        <th>Voucher No </th>
                                                        <th>Total Amount </th>
                                                        <th>Collect Amount</th>
                                                        <th>Status</th>
                                                        <th>Entry By</th>
                                                        <th>Entry Date</th>
                                                        <th>Auth By</th>
                                                        <th>Auth date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php 
                                                        $sl=1;
                                                    @endphp
                                                	  @foreach($all_pedding_bills as $single_get_data)
                                                      
                                                      <tr>
                                                          <td>{{$sl++}}</td>
                                                          <td>{{$single_get_data->client_name}}</td>
                                                          <td>{{$single_get_data->challan_no}}</td>
                                                          <td>{{$single_get_data->total_amount}}</td>
                                                          <td>{{$single_get_data->collect_amount}}</td>
                                                          <td>
                                                              @if($single_get_data->status=='0')
                                                                <span class="text-danger">Unauthorize</span>

                                                                @elseif($single_get_data->status=='1')
                                                                <span class="text-success">Authorized</span> 

                                                              @endif
                                                             </td>
                                                          <td>{{$single_get_data->generate_by}}</td>
                                                          <td>{{$single_get_data->entry_date}}</td>
                                                          <td>{{$single_get_data->auth_by}}</td>
                                                          <td>{{$single_get_data->auth_date}}</td>
                                                          
                                                          <td>
                                                          @if($single_get_data->status=='0')
                                                              <a target="_blank"  class="btn btn-warning btn-sm"href="{{ url('factory/bill/bill_authorize') }}/{{$single_get_data->id}}" class="btn btn-primary btn-sm" >Authorize</a></td>
                                                          @endif
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


    </script>


@endpush
