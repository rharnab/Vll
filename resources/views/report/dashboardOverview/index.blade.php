@extends('layouts.app')

@section('title', 'Home')
@push('css')
<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

<style>
    .amount_area{
        font-size: 1.0rem;
    }

    a[target]:not(.btn) {
           
            text-decoration: none !important;
        }
    .custom_height{
            height: 120 px;
    }
</style>
@endpush

@section('content')

<div class="container">
    <div class="row justify-content-center">   


                      
                            
                            
                             <div class="col-sm-2 col-xl-2">
                                <a href="{{ route('dashboard.report.rack', [date('Y-m')]) }}" target="_blank">
                                <div class=" p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                             <span class="amount_area">{{ $this_month_rack[0]->this_month_rack }}  <i class="fa fa-long-arrow-alt-right"></i> </span>   
                                            <small class="m-0 l-h-n">This month rack</small>
                                        </h3> 
                                      
                                    </div>

                                    

                                    <i class="fa fa-archive  position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1 text-center" style="font-size:6rem"></i>
                                </div>
                            </a>
                            </div>
                            
                            



                            <div class="col-sm-2 col-xl-2">
                                <a href="{{ route('dashboard.report.rack', [date('Y-m', strtotime('-1 month', strtotime(date('Y-m-t')) ))]) }}" target="_blank">
                                <div class=" p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                              <span class="amount_area">  {{ $last_month_rack[0]->last_month_rack }}  <i class="fa fa-long-arrow-alt-right"></i> </span>
                                            <small class="m-0 l-h-n">Last month rack</small>
                                        </h3>
                                    </div>
                                    <i class="fa fa-archive position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                                </a>
                            </div>
                            
                            <div class="col-sm-2 col-xl-2">
                                <a href="{{ route('dashboard.report.due_shop') }}" target="_blank">
                                <div class=" p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <span class="amount_area">  {{ count($previous_due_result) }} <i class="fa fa-long-arrow-alt-right"></i> </span>
                                            <small class="m-0 l-h-n">Due Shop</small>


                                        </h3>
                                      
                                           
                                    </div>

                                    <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                                </a>
                                
                            </div>

                            <div class="col-sm-2 col-xl-2">
                                <div class=" p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                              

                                            <span class="amount_area">  {{ $socks_rack[0]->total_socks_rack }} </span>

                                             
                                            <small class="m-0 l-h-n">Socks Rack </small>
                                        </h3>
                                    </div>
                                    <i class="fas fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-2 col-xl-2">
                                <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            

                                              <span class="amount_area"> {{ $combine_racks[0]->total_combine_racks }} </span>
                                            <small class="m-0 l-h-n">Combine Rack</small>
                                        </h3>
                                    </div>
                                    <i class="fas fa-tshirt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>


                            <div class="col-sm-2 col-xl-2">
                                <a href="{{ route('dashboard.report.close_shop') }}" target="_blank">
                                <div class="p-3 bg-primary-200 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                              <span class="amount_area">  {{ $close_shop }} </span>
                                            <small class="m-0 l-h-n">Close Shop</small>
                                        </h3>
                                    </div>
                                    <i class="fa fa-archive position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                                </a>
                            </div>
                            
                            
                             <div class="col-sm-2 col-xl-2">
                                
                                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <span class="amount_area"> {{ $last_month_sale_socks[0]->last_month_sale_socks }}</span>
                                            <small class="m-0 l-h-n">Last Month socks Sale</small>


                                        </h3>
                                         
                                           
                                    </div>

                                    <i class="fa fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                                
                            </div>
                            
                             <div class="col-sm-2 col-xl-2">
                                
                                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                           <span class="amount_area"> {{ $last_month_sale_pant[0]->last_month_sale_pant }}</span>
                                            <small class="m-0 l-h-n">Last Month Pant Sale</small>


                                        </h3>
                                         
                                           
                                    </div>

                                    <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                                
                            </div>
                            
                            



                            <div class="col-sm-2 col-xl-2">
                                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <span class="amount_area"> {{ $last_month_sale_tshirt[0]->last_month_sale_tshirt }}</span>
                                            <small class="m-0 l-h-n">Last Month T-shirt Sale</small>
                                        </h3>
                                    </div>
                                    <i class="fa fa-tshirt position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-2 col-xl-2">
                                
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                              
    
                                            <span class="amount_area">{{ $this_month_sale_socks[0]->this_month_sale_socks }} </span>

                                             
                                            <small class="m-0 l-h-n">This Month socks Sale</small>
                                        </h3>
                                    </div>
                                    <i class="fas fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                               
                            </div>

                            <div class="col-sm-2 col-xl-2">
                                <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            
                                            <span class="amount_area">{{ $this_month_sale_pant[0]->this_month_sale_pant }} </span>
                                              
                                            <small class="m-0 l-h-n">This Month Pant Sale</small>
                                        </h3>
                                    </div>
                                    <i class="fas fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>


                            <div class="col-sm-2 col-xl-2">
                                <div class="p-3 bg-primary-200 rounded overflow-hidden position-relative text-white mb-g text-center">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <span class="amount_area">{{ $this_month_sale_tshirt[0]->this_month_sale_tshirt }} </span>
                                            <small class="m-0 l-h-n">This Month T-shirt Sale</small>
                                        </h3>
                                    </div>
                                    <i class="fa fa-tshirt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                {{---------------------- all amount ----------------------}}

                           
 {{-- socks in stock --}}

 <div class="col-sm-4 col-xl-4">
    <a href="#" target="_blank">
        <div class="p-3  bg-danger-200 rounded overflow-hidden position-relative text-white mb-g text-center custom_height">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <span class="amount_area"> {{ ($stocks_in_socks[0]->total_socks)? $stocks_in_socks[0]->total_socks : 0  }} {{-- <i class="fa fa-long-arrow-alt-right"></i> --}} </span>
                    <small class="m-0 l-h-n font-weight-bold">Stock In Socks </small>
                </h3>
            </div>
            <i class="fa fa-tshirt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </a>
</div>
{{-- end  socks in Stock --}}


{{-- socks in pant --}}

<div class="col-sm-4 col-xl-4">
    <a href="#" target="_blank">
        <div class="p-3  bg-danger-200 rounded overflow-hidden position-relative text-white mb-g text-center custom_height">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <span class="amount_area"> {{ ($stocks_in_pant[0]->total_pant)? $stocks_in_pant[0]->total_pant: 0  }} {{-- <i class="fa fa-long-arrow-alt-right"></i> --}} </span>
                    <small class="m-0 l-h-n font-weight-bold">Stock In Pant </small>
                </h3>
            </div>
            <i class="fa fa-tshirt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </a>
</div>
{{-- end  socks in pant --}}


{{-- socks in TShirt --}}

<div class="col-sm-4 col-xl-4">
<a href="#" target="_blank">
    <div class="p-3  bg-danger-200 rounded overflow-hidden position-relative text-white mb-g text-center custom_height">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span class="amount_area"> {{ ($stocks_in_tshirt[0]->total_tshirt)? $stocks_in_tshirt[0]->total_tshirt: 0  }} {{-- <i class="fa fa-long-arrow-alt-right"></i> --}} </span>
                <small class="m-0 l-h-n font-weight-bold">Stock In T-shirt </small>
            </h3>
        </div>
        <i class="fa fa-tshirt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
    </div>
</a>
</div>
{{-- end  socks in TShirt --}}


                            
                            
                    
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
                {
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
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Generate Excel',
                    className: 'btn-outline-success btn-sm mr-1'
                }
            ],
    
            "lengthMenu": [
                [10, 50, 100, -1]
            ]
        });
    
    });
    
    /*data table script*/
    </script>
    
@endpush

