@extends('layouts.app')
@section('title','Lead')

@push('css')



<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item active"> In Complete Task </li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="subheader">
        <h1 class="subheader-title">
            <span style="float:right">
                <a href="{{route('lead.create')}}" class="btn btn-sm btn-primary">
                    <span class="fal fa-plus mr-1"></span> Add New
                </a>
            </span>
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <!-- data table -->
            <div id="panel-1" class="panel">
                <div class="panel-hdr">

                    <h2>Incomplete task list </h2>
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
                                    <th>Lead Create </th>
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
                                    <th>Option</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $sl=1; @endphp
                                @foreach($leades as $data)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->lead_date }}</td>
                                    <td>{{ $data->area_name }}</td>
                                    <td>{{ $data->work_name }}</td>
                                    <td>{{ ($data->shop_name)? $data->shop_name: '-' }}</td>
                                    <td>{{ ($data->area)? $data->area :'-' }}</td>
                                    <td>{{ ($data->rach_change_type)? $data->rach_change_type:'-' }}</td>
                                    <td>{{ ($data->due_amount)? $data->due_amount:'-' }}</td>
                                    <td>{{ ($data->full_amount)? $data->full_amount:'-' }}</td>
                                    <td>{{ ($data->partial_amount)? $data->partial_amount: '-' }}</td>
                                    <td>{{ ($data->payment_mode)? $data->payment_mode: '-' }}</td>
                                    <td>{{ ($data->remarks)? $data->remarks:'-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary"
                                            onclick="updateLead({{ $data->id }})">Complete</button>
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


<script>
    function updateLead(id)
    {
        if(id != ''){
            $.ajax({
                type:'post',
                url:"{{ route('lead.update') }}",
                data:{id: id, "_token": "{{ @csrf_token() }}" },
                beforeSend:function(){
                    loaderStart();
                },
                success:function(data)
                {
                    if(data.status == 200){
                        cuteAlert({
                            type      : "success",
                            title     : "Success",
                            message   : data.message,
                            buttonText: "ok"
                        }).then((e)=>{
                            location.reload(true);
                        });
                    }else if(data.status == 400){

                        cuteAlert({
                            type      : "warning",
                            title     : "Warning",
                            message   : data.message,
                            buttonText: "ok"
                        })


                    }else{

                        alert(data.message);                                        
                    }

                },
                complete:function(){
                    loaderEnd();
                }
            })
        }
    }
</script>



@endpush