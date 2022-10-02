@extends('layouts.app')
@section('title','Direct Sale Bill Authorize')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Direct Sale</li>
            <li class="breadcrumb-item active"> Direct Sale Bill Collection </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>


        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Direct Sale Bill Collection
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
                                                        <th>Voucher No </th>
                                                        <th> Total Amount </th>
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
                                                	  @foreach($get_data as $single_get_data)
                                                      
                                                      <tr>
                                                          <td>{{$sl++}}</td>
                                                          <td>{{$single_get_data->voucher_no}}</td>
                                                          <td>{{$single_get_data->total_amount}}</td>
                                                          <td>{{$single_get_data->collect_amount}}</td>
                                                          <td>
                                                              @if($single_get_data->status=='0')
                                                                <span class="text-danger">Unauthorize</span>

                                                                @elseif($single_get_data->status=='1')
                                                                <span class="text-success">Authorized</span> 

                                                              @endif
                                                             </td>
                                                          <td>{{$single_get_data->entry_by}}</td>
                                                          <td>{{$single_get_data->entry_date}}</td>
                                                          <td>{{$single_get_data->auth_name}}</td>
                                                          <td>{{$single_get_data->auth_date}}</td>
                                                          
                                                          <td>
                                                          @if($single_get_data->status=='0')
                                                              <a type="button" class="btn btn-primary btn-sm" onclick="authorize_bill({{$single_get_data->id}});">Authorize</a></td>
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


    <script>

function authorize_bill(id){
    cuteAlert({
    type: "question",
    title: "Do you want to authorize",
    message: "Okay or Cancel",
    confirmText: "Okay",
    cancelText: "Cancel"
    }).then((e)=>{
    if ( e == ("confirm")){

        $.ajax({
                type:"POST",
                url:"{{ route('direct_sale.bill-collection.bill_voucher_authorize') }}",
                data:{
                    id: id,
                  
                    "_token": " {{ csrf_token() }} ",
                },
                success:function(data)
                {
                    if(data=='1'){
                        
                        cuteAlert({
                            type      : "success",
                            title     : "success",
                            message   : 'Bill authorized successfully',
                       
                        });
                    }
                   
                     location.reload(true);
                    
                }
            });

        }
    })
        

           
            
        }
    </script>

@endpush
