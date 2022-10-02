@extends('layouts.app')
@section('title','Shop Voucher')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item active">Rack Refil Voucher </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                        Rack Refil Voucher Report List
                                        </h2>

                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content ">
                                        
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2"> Shop Filter:</label>
                                            <div class="col-sm-4">
                                                <select id="table-filter" class="select2">
                                                    <option value="">All</option>
                                                    @foreach($data as $single_data)

                                                        <option>{{ $single_data->name }}</option>
                                                    
                                                    @endforeach   
                                                </select>
                                            </div>
                                        </div>

                                        
                                        
                                            <!-- datatable start -->
                                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100 mytable">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>Shop Name</th>
                                                        <th>Rack Code</th>
                                                        <th>Voucher</th>
                                                        <th>Generate Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody> 
                                              @php $sl=1; @endphp
                                               @foreach($data as $single_data)
                                                    <tr>
                                                        <td>{{ $sl++ }}</td>
                                                        <td>{{ $single_data->name }}</td>
                                                        <td>{{ $single_data->rack_code }}</td>
                                                        <td><a  href="{{ asset('public/'.$single_data->store_location) }}">{{ $single_data->voucher_name }}</a></td>
                                                        <td>{{ date('M-d-Y', strtotime($single_data->entry_datetime)) }}</td>
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


    
    $(document).ready(function (){
                 var table = $('#dt-basic-example').DataTable({
                    dom: 'lrtip',
                    responsive: true,
                    lengthChange: false,
                    "pageLength": 50,

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
    
            $('#table-filter').on('change', function(){
                table.search(this.value).draw();   
            });
        });

        
     
            

 
    </script>




@endpush
