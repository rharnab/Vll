@extends('layouts.app')
@section('title','Lead Report')

@push('css')



<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active"> Lead Report Details Info </li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="subheader">

    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <!-- data table -->
            <div id="panel-1" class="panel">
                <div class="panel-hdr">

                    <h2>Summary Report Info  form [ {{ $start_dt }} To {{ $end_dt }} ] Lead User [ {{ $lead_user }} ]</h2>
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
                        <!-- datatable start -->
                        <table
                            class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
                       
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>#Sl</th>
                                    <th>Lead Date</th>
                                    <th>Wark Area</th>
                                    <th>Wark Type</th>
                                    <th>Shop Name</th>
                                    <th>Shop area</th>
                                   
                                    <th>Rack Type</th>
                                    
                                    <th>Due Amount</th>
                                    <th>Full Amount</th>
                                    <th>Partial Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                          
                            <tbody>
                                @php $sl=1; @endphp
                                @foreach($details as $data)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $data->lead_date }}</td>
                                    <td>{{ $data->area_name }}</td>
                                    <td>{{ $data->work_name }}</td>
                                    <td>{{ ($data->shop_name)? $data->shop_name: '-' }}</td>
                                    <td>{{ ($data->area)? $data->area :'-' }}</td>
                                    <td>{{ ($data->rach_change_type)? $data->rach_change_type:'-'  }}</td>
                                    <td>{{ ($data->due_amount)? $data->due_amount:'-'  }}</td>
                                    <td>{{ ($data->full_amount)? $data->full_amount:'-' }}</td>
                                    <td>{{ ($data->partial_amount)? $data->partial_amount: '-'  }}</td>
                                    <td>{{ ($data->payment_mode)? $data->payment_mode: '-' }}</td>
                                    <td>{{ ($data->remarks)? $data->remarks:'-'  }}</td>
                                    <td>
                                        @if($data->status == 1)
                                        Complete
                                        @else
                                        Incomplete
                                        @endif
                                    </td>
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