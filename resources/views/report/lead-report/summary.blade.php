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
        <li class="breadcrumb-item active"> Lead Report Summary Info </li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="subheader">

    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <!-- data table -->
            <div id="panel-1" class="panel">
                <div class="panel-hdr">

                    <h2>Summary Report Info  form [ {{ $start_dt }} To {{ $end_dt }} ]</h2>
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
                                    <th>Lead User</th>
                                    @foreach($works_type as $single)
                                    <th>{{ $single->work_name }}</th>
                                    @endforeach
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sl=1; @endphp
                                @foreach($leads_info as $data)

                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $data->lead_user_name }}</td>

                                    <td>{{ ($data->new_shop_select)? $data->new_shop_select: 0 }}</td>
                                    <td>{{ ($data->rack_delivery)? $data->rack_delivery: 0 }}</td>
                                    <td>{{ ($data->sales_update)? $data->sales_update: 0 }}</td>
                                    <td>{{ ($data->refill)? $data->refill:0 }}</td>
                                    <td>{{ ($data->product_return)? $data->product_return: 0 }}</td>
                                    <td>{{ ($data->rack_return)? $data->rack_return: 0 }}</td>
                                    <td>{{ ($data->bill_collection)? $data->bill_collection: 0 }}</td>
                                    <td>{{ ($data->rack_change)? $data->rack_change: 0 }}</td>
                                    <td>{{ ($data->lead_visit)? $data->lead_visit:0 }}</td>
                                    <td>{{ ($data->app_delivery)? $data->app_delivery:0  }}</td>
                                    <td>
                                        <form method="post" action="{{ route('report.lead.details') }}" target="_blank">
                                        <form method="post" action="{{ route('report.lead.details') }}" target="_blank">
                                            @csrf
                                            <input type="hidden" id="lead_id" name="lead_id" value="{{ $data->lead_id }}">
                                            <input type="hidden" id="start_dt" name="start_dt" value="{{ $start_dt}}">
                                            <input type="hidden" id="end_dt" name="end_dt" value="{{ $end_dt}}">
                                            <input type="hidden" id="rqst_work_type" name="rqst_work_type" value="{{ $rqst_work_type }}">
                                            <input type="hidden" id="status" name="status" value="{{ $status }}">
                                            <button class="btn btn-primary btn-sm" type="submit" >Details</button>
                                        </form>
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