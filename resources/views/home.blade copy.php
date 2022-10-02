@extends('layouts.app')

@section('title', 'Home')
@push('css')
<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush
@section('content')

<div class="container">
    <div class="row justify-content-center">   


                      
                            <div class="col-sm-3 col-xl-3">
                                
                                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            @php

                                            $lots_count = DB::table('lots')->count();

                                            echo $lots_count;

                                            @endphp
                                            <small class="m-0 l-h-n">Lot</small>


                                        </h3>
                                         
                                           
                                    </div>

                                    <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                                
                            </div>



                            <div class="col-sm-3 col-xl-3">
                                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            @php

                                            $stocks_count = DB::table('stocks')->count();

                                            echo $stocks_count;
                                            
                                            @endphp
                                            <small class="m-0 l-h-n">Packet</small>
                                        </h3>
                                    </div>
                                    <i class="fa fa-archive position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-3 col-xl-3">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                              

                                             @php

                                                $totatl_socks =  DB::select(DB::raw("SELECT sum(per_packet_shocks_quantity) as total_socks_pair FROM `stocks` "))[0];

                                                echo $totatl_socks->total_socks_pair;
                                             @endphp

                                             
                                            <small class="m-0 l-h-n">Socks </small>
                                        </h3>
                                    </div>
                                    <i class="fas fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-3 col-xl-3">
                                <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                             @php

                                                $totatl_socks =  DB::select(DB::raw("SELECT sum(remaining_socks) as total_remaining_socks FROM `stocks` "))[0];

                                                echo $totatl_socks->total_remaining_socks;
                                             @endphp

                                              Pair
                                            <small class="m-0 l-h-n">Remaining Socks</small>
                                        </h3>
                                    </div>
                                    <i class="fas fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>


                            <div class="col-sm-3 col-xl-3">
                                <div class="p-3 bg-primary-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                             @php

                                                $totatl_socks =  DB::select(DB::raw("SELECT count(remaining_socks) as total_remaining_packets FROM `stocks` WHERE remaining_socks>0 "))[0];

                                                echo $totatl_socks->total_remaining_packets;
                                             @endphp 
                                            <small class="m-0 l-h-n">Remaining Paket</small>
                                        </h3>
                                    </div>
                                    <i class="fa fa-archive position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>


                            <div class="col-sm-3 col-xl-3">

                                 <a href="{{url('parameter-setup/racks/index')}}" style="cursor: pointer;">
                                <div class="p-3 bg-warning-500 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            @php 
                                              $total_racks =  DB::table('racks')->count();
                                              echo $total_racks;
                                            @endphp 
                                            <small class="m-0 l-h-n">Rack</small>
                                        </h3>

                                         <i class="fa fa-long-arrow-alt-right" style="float:right;font-size: 30px;margin-top: -29px;color: #fff;"></i>

                                    </div>
                                    <i class="fas fa-tasks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                                </a>
                            </div>


                            <div class="col-sm-3 col-xl-3">
                                <a href="{{url('parameter-setup/shops/index')}}" style="cursor: pointer;">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                             @php 
                                              $total_shops =  DB::table('shops')->count();
                                              echo $total_shops;
                                            @endphp  
                                            <small class="m-0 l-h-n">Shop</small>
                                        </h3>

                                         <i class="fa fa-long-arrow-alt-right" style="float:right;font-size: 30px;margin-top: -29px;color: #fff;"></i>

                                    </div>
                                    <i class="fas fa-store position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                                </a>
                            </div>


                              <div class="col-sm-3 col-xl-3">
                                <a href="{{url('parameter-setup/agent/index')}}" style="cursor: pointer;">
                                <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                             @php 
                                              $total_agent_users =  DB::table('agent_users')->count();
                                              echo $total_agent_users;
                                            @endphp   
                                            <small class="m-0 l-h-n">Agent</small>
                                        </h3>
                                        <i class="fa fa-long-arrow-alt-right" style="float:right;font-size: 30px;margin-top: -29px;color: #fff;"></i>

                                    </div>
                                    <i class="fas fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                                </a>
                            </div>
                    
</div>

<div class="row">
    <div class="col-xl-12">
        <!-- data table -->
         <div id="panel-1" class="panel">
                            <div class="panel-hdr">
                                <h2>
                                    Client Sales Update
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
                                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100 table-responsive dataTable">
                                        <thead class="bg-primary-600" style="text-transform: uppercase">
                                            <tr>
                                                <th>#SL</th>
                                                <th>Client Name</th>
                                                <th>Area</th>
                                                <th>C.Person</th>
                                                <th>Phone No</th>
                                                <th>Rack Code</th>
                                                <th>Agent</th>
                                                <th>Reg Date</th>
                                                <th>Last Sales Up.</th>
                                                <th>Last Sales D.</th>
                                                <th>Remaining</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sales_update as $sales)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td>{{ $sales->shop_name }}</td>
                                                    
                                                    <td>{{ $sales->area }}</td>
                                                    <td class="text-capitalize">{{ $sales->select_contact ?? 'Manager'}}</td>
                                                    
                                                    <td> 
                                                    @if(!empty($sales->contact_no1))

                                                        {{$sales->contact_no1}}

                                                    @elseif(!empty($sales->contact2))
                                                        {{$sales->contact2}}

                                                    @elseif(!empty($sales->contact3))
                                                        {{$sales->contact3}}
                                                        
                                                    @endif
                                                    </td>
                                                    
                                                    <td>{{ $sales->rack_code }}</td>
                                                    <td>{{ $sales->agent_name }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($sales->entry_date)) }}</td>                                                   
                                                    <td>{{ $sales->total_due_sold }} Pair</td>
                                                    <td>
                                                        @if($sales->total_due_sold  == 0)
                                                            -
                                                        @else 
                                                            {{ date('d/m/Y', strtotime($sales->last_sales_update_date)) }}
                                                        @endif                                                        
                                                    </td>
                                                    <td>{{ $sales->total_unsold }} Pair</td>

                                                   
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
</div>
@endsection
@push('js')
<script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>

<script>
    /*data table script*/
    
    $(document).ready(function() {
    
        // initialize datatable
         $('.dataTable').dataTable({
            responsive: true,
            lengthChange: false,
            "searching": true,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
               /* {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    titleAttr: 'Generate PDF',
                    className: 'btn-outline-danger btn-sm mr-1'
                },
    
                {
                    extend: 'print',
                    text: 'Print',
                    titleAttr: 'Print Table',
                    className: 'btn-outline-primary btn-sm'
                }*/
            ],
    
            "lengthMenu": [
                [100, 200, 500, -1]
            ]
        });
    
    });
    
    /*data table script*/
    </script>
    
@endpush
