@extends('layouts.app')
@section('title','Lot Summary Report')

@push('css')


<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Report</li>
            <li class="breadcrumb-item ">Stock Report</li>
            <li class="breadcrumb-item active">Lot Summary Report</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Lot Summary Report  [ <span class="font-weight-bold text-danger p-1">{{ $status_type }}</span> ] </h2>
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
                                        @if($status == 2)
                                            <!-- datatable start  for sold-->
                                            <table  class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable table-responsive">
                                                <thead class="bg-primary-600">
                                                    <tr class="text-uppercase">
                                                        <th>#SL</th>
                                                        <th>Lot No</th>
                                                        <th>Total Shocks</th>
                                                        <th>Total remaining</th>
                                                        <th>Sold Shocks</th>
                                                        <th>Total DP Price</th>
                                                        <th>Total TP Price</th>
                                                        <th>Category</th>
                                                        <th>Details</th>
                                                    </tr>


                                                </thead>

                                                <tbody>

                                                    @php $sl=1; @endphp
                                                    @foreach($lots as $single_data)
                                                	   <tr>
                                                           <td>{{$sl++}}</td>
                                                           <td>{{$single_data->lot_no}}</td>
                                                           
                                                           <td>{{$single_data->total_shocks}} pair</td>
                                                           <td>{{$single_data->total_remaining_socks}} pair</td>
                                                           <td>{{$single_data->sold_socks}} pair</td>
                                                            <td>{{number_format($single_data->total_buying_price,2)}} </td>
                                                           <td>{{number_format($single_data->total_saling_price,2)}} </td>
                                                           <td>{{$single_data->name}}</td>
                                                           <td><button class="btn btn-primary btn-sm" onclick="LotDetails({{ $single_data->lot_no}} , {{ $single_data->cat_id }})" > Details</button></td>
                                                           
                                                       </tr>

                                                    @endforeach                                          
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>{{ $summation[0]->grand_total_lot }}</th>
                                                        
                                                        <th>{{ $summation[0]->grand_total_shocks }} Pair</th>
                                                        <th>{{ $summation[0]->grand_total_remaining_socks }} Pair</th>
                                                        <th>{{ $summation[0]->grand_total_sold_socks }} pair</th>
                                                        <th>{{ number_format($summation[0]->grand_total_buy_price, 2) }}</th>
                                                        <th>{{ number_format($summation[0]->grand_total_sale_price, 2) }}</th>
                                                        <th></th>
                                                       
                                                        
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!-- datatable end for sold -->
                                            @elseif($status == 3)
                                                <!-- datatable start  for sold-->
                                                <table  class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
                                                    <thead class="bg-primary-600">
                                                        <tr class="text-uppercase">
                                                            <th>#SL</th>
                                                            <th>Lot No</th>
                                                            <th>Total Shocks</th>
                                                            <th>Total remaining</th>
                                                            <th>UnSold Shocks</th>
                                                            <th>Total DP Price</th>
                                                            <th>Total TP Price</th>
                                                            <th>Category</th>
                                                            <th>Details</th>
                                                        </tr>
    
    
                                                    </thead>
    
                                                    <tbody>
    
                                                        @php $sl=1; @endphp
                                                        @foreach($lots as $single_data)
                                                            <tr>
                                                                <td>{{$sl++}}</td>
                                                                <td>{{$single_data->lot_no}}</td>
                                                                
                                                                <td>{{$single_data->total_shocks}} pair</td>
                                                                <td>{{$single_data->total_remaining_socks}} pair</td>
                                                                <td>{{$single_data->unsold_socks}} pair</td>
                                                                <td>{{number_format($single_data->total_buying_price,2)}} </td>
                                                                <td>{{number_format($single_data->total_saling_price,2)}} </td>
                                                                <td>{{$single_data->name}}</td>
                                                                <td><button class="btn btn-primary btn-sm" onclick="LotDetails({{ $single_data->lot_no}} , {{ $single_data->cat_id }})" > Details</button></td>
                                                                
                                                            </tr>
    
                                                        @endforeach                                          
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th>{{ $summation[0]->grand_total_lot }}</th>
                                                            
                                                            <th>{{ $summation[0]->grand_total_shocks }} Pair</th>
                                                            <th>{{ $summation[0]->grand_total_remaining_socks }} Pair</th>
                                                            <th>{{ $summation[0]->grand_total_unsold_socks }} pair</th>
                                                            <th>{{ number_format($summation[0]->grand_total_buy_price, 2) }}</th>
                                                            <th>{{ number_format($summation[0]->grand_total_sale_price, 2) }}</th>
                                                            <th></th>
                                                            
                                                            
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <!-- datatable end for sold -->
                                            
                                            @else

                                            <!-- datatable start  for stock-->
                                            <table  class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
                                                <thead class="bg-primary-600">
                                                    <tr class="text-uppercase">
                                                        <th>#SL</th>
                                                        <th>Lot No</th>
                                                        
                                                        <th>Total Shocks</th>
                                                        <th>Total remaining</th>
                                                        <th>Total DP Price</th>
                                                        <th>Total TP Price</th>
                                                        <th>Category</th>
                                                        <th>Details</th>
                                                    </tr>


                                                </thead>

                                                <tbody>

                                                    @php $sl=1; @endphp
                                                    @foreach($lots as $single_data)
                                                	   <tr>
                                                           <td>{{$sl++}}</td>
                                                           <td>{{$single_data->lot_no}}</td>
                                                           
                                                           <td>{{$single_data->total_shocks}} pair</td>
                                                           <td>{{$single_data->total_remaining_socks}} pair</td>
                                                            <td>{{number_format($single_data->total_buying_price,2)}} </td>
                                                           <td>{{number_format($single_data->total_saling_price,2)}} </td>
                                                           <td>{{$single_data->name}}</td>
                                                           <td><button class="btn btn-primary btn-sm" onclick="LotDetails({{ $single_data->lot_no}} , {{ $single_data->cat_id }})" > Details</button></td>
                                                           
                                                           
                                                       </tr>

                                                    @endforeach                                          
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>{{ $summation[0]->grand_total_lot }}</th>
                                                        
                                                        <th>{{ $summation[0]->grand_total_shocks }} Pair</th>
                                                        <th>{{ $summation[0]->grand_total_remaining_socks }} Pair</th>
                                                        <th>{{ number_format($summation[0]->grand_total_buy_price, 2) }}</th>
                                                        <th>{{ number_format($summation[0]->grand_total_sale_price, 2) }}</th>
                                                        <th></th>
                                                       
                                                        
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!-- datatable end for stock -->
                                            @endif
                                        </div>
                                    </div>
                                
                         
                                </div>


                              

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ---------bootstrap modal ---------------------}}

        <div id="LotDetails" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lot Details [ <span class="lot_no  text-danger font-weight-bold"> </span> ] </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" id="lot_details">
                        
                        
                    </div>
                
                </div>
            </div>
            </div>
            {{-- ---------bootstrap modal ---------------------}}
    </main>
 
@endsection

@push('js')

 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>

 <script>

function LotDetails(lot_no, cat_id)
    {

      

        $('#LotDetails').modal('show');
        if(lot_no != '')
        {
            $.ajax({
                type:'POST',
                url: "{{ route('report.cash_report.lot-info-details') }}",
                data:{ "lot_no": lot_no, "cat_id": cat_id, "_token": '{{ csrf_token()}}'},
                //dataType:"json", 
                beforeSend: function()
                {
                    loaderStart();
                },
                success:function(data)
                {
                    
                    $('#lot_details').html(data);
                    $('.lot_no').html(lot_no)
                    $('#shopDetails').modal('show');
                    //console.log(data);
                    dataTableWithBUtton();

                },
                complete:function()
                {
                    loaderEnd();
                }

            });
        }
    }

        
</script>

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
