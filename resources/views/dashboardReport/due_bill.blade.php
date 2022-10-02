@extends('layouts.app')
@section('title','Due Bill Details Report')

@push('css')


<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item ">Bill Report</li>
            <li class="breadcrumb-item active">Due Bill Details Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        
                       

                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                            </div>
                        </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                       
                                            <!-- datatable start  for sold-->
                                            <table  class="table table-bordered  table-hover table-striped table-sm w-100 text-center dataTable">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>#SL</th>
                                                        <th>Name</th>
                                                        <th>Rack Code</th>
                                                        <th>Contact Number</th>
                                                        <th>Last Payment</th>
                                                        <th>VLL Amount</th>
                                                        <th>Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $sl=1; $total_vll_amount=0; $total_due_bill=0@endphp
                                                    @foreach($previous_due_result as $single_result)
                                                    @php
                                                    $total_vll_amount += $single_result->total_venture_amount + $single_result->total_agent_commission;
                                                    $total_due_bill += $single_result->total_bill;
                                                    @endphp
                                                  
                                                   <tr >
                                                        <td>{{ $sl++ }}</td>
                                                        <td onclick="ShowDetails(' {{ $single_result->shop_id }}', '{{ $single_result->rack_code }}')" >{{ $single_result->shop_name }}</td>
                                                        <td style="text-decoration:underline;cursor:pointer;" onclick="show_socks('{{ $single_result->rack_code}}')">{{ $single_result->rack_code}}</td>
                                                        <td>{{ ($single_result->shop_contact)? $single_result->shop_contact : $single_result->owner_contact }}</td>
                                                        <td>{{ $single_result->last_billing_date ? date('Y-m-d', strtotime($single_result->last_billing_date)) : 'Not Payment'  }} </td>
                                                        <td>{{ number_format(($single_result->total_venture_amount + $single_result->total_agent_commission) , 2) }} /=</td>     
                                                        <td>{{ number_format($single_result->total_bill, 2) }} /=</td>                            
                                                    </tr>
                                                   
                                                   
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Total</td>
                                                        <td>{{ number_format($total_vll_amount, 2) }}</td>
                                                        <td>{{ number_format($total_due_bill, 2) }}</td>
                                                       
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                
                         
                                </div>


                              

                        </div>
                    </div>
                </div>
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
    function ShowDetails(shop_id, rack_code)
    {
        if(shop_id != '' && rack_code !='')
        {
            $.ajax({
                type:'POST',
                url: "{{ url('dashboard/shop_details') }}",
                data:{ "shop_id": shop_id, "rack_code": rack_code, "_token": '{{ csrf_token()}}'},
                dataType:"json", 
               beforeSend: function()
                {
                    loaderStart();
                },
                success:function(data)
                {
                    $('#shop_name').html(data.name);
                    $('#rack_code').html(data.rack_code);
                    $('#agent_name').html(data.agent_name);
                    $('#address').html(data.shop_address);
                    $('#area').html(data.area);
                    
                    

                    if(data.contact_no != null)
                    {
                        $('#contact').html(data.contact_no);

                    }else{
                        $('#contact').html(data.owner_contact);
                    }
                   
                    $('#shopDetails').modal('show');
                     console.log(data);
                },
                complete:function()
                {
                    loaderEnd();
                }

            });
        }
        //$('#staticBackdrop').modal('show');
    }

    function show_socks(rack_code){
        var _token            = $("#_token").val();

        $.ajax({
            type: 'POST',
            url : "{{route('rack.rack-fillup.rack_socks_details')}}",
            data: {
                    "_token"   : _token,
                "rack_id"     : rack_code,
            },
            beforeSend: function() {
                loaderStart();
            },
            success: (data) => {
                
                

                if (data) {
                    $("#modal_title").html(`<h2 ><span class='text-danger'> `+rack_code+` </span> Current Available Socks Deatils</h2>`);  
                    $("#show_data").html(data);  

                    $("#myModal").modal('show');  
                }else{
                        cuteAlert({
                            type: "warning",
                            title: "warning",
                            message: "No Data Found !",
                            buttonText: "Okay"
                        });  

                        return false;
                }

                

            },
            error: function(data) {
                
            },
            complete: function() {
                loaderEnd();
            }
        });     // end ajax

    }
</script>

@endpush
