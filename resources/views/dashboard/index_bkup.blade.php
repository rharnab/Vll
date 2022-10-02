@extends('layouts.app')

@section('title', 'Home')
@push('css')

<style>
aside.page-sidebar {
    display: none;
}

.page-header {
    display: none;
}
.display-4{
    font-size: 1.7rem !important;
}
.h5 {
    font-size: 0.8rem !important;
}
</style>

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@section('content')


<div class="subheader">
    <h1 class="subheader-title">            
        <span>
            <a href="{{url('/')}}" class="btn btn-sm btn-primary">
                <span class="fa fa-home mr-1"></span> Home
            </a>
        </span>
        
    </h1>
</div>
    <div class="row">


        <!--<div class="col-sm-2 col-xl-2">
            <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g" >
                <div class="text-center">
                    <a href="#" class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{ number_format($upto__due_bill_amt, 2) }} </span>
                        <small class="m-0 l-h-n h5 d-block">Up To Due Bill</small>
                    </a>

                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>
        </div>-->


        <!--<div class="col-sm-2 col-xl-2 ">
            <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g" >
                <div class="text-center">
                    <a href="#" class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{ number_format($this_month_due_bill_amt, 2) }} </span>
                        <small class="m-0 l-h-n h5 d-block">This month Due Bill</small>
                    </a>


                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>
        </div>-->

        <!--<div class="col-sm-2 col-xl-2" >

            <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white mb-g" >
                <div class="text-center">
                    <a href="#" class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{ number_format($this_month__bill_collect_result, 2) }} </span>
                        <small class="m-0 l-h-n h5 d-block">This  month Bill colllection</small>
                    </a>


                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>

        </div>-->

        <!--<div class="col-sm-2 col-xl-2" >

            <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white mb-g">
                <div class="text-center">
                    <a href="#" class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{ number_format($upto__bill_collect_amt, 2) }} </span>
                        <small class="m-0 l-h-n h5 d-block">Up To Bill Collection </small>
                    </a>


                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>

        </div>-->



        <div class="col-sm-2 col-xl-2" >

            <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g" >
                <div class="text-center">
                    <a href="{{ url('dashboard/details', 'refill') }}"
                        class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{ $toatal_rack_refils }} </span>
                        <small class="m-0 l-h-n h6 d-block" >Need to Refill</small>
                    </a>
                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>

        </div>


        <div class="col-sm-2 col-xl-2" >

            <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g" >
                <div class="text-center">
                    <a href="{{ url('dashboard/details', 'refill') }}"
                        class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{ $this_month_shop_number }} </span>
                        <small class="m-0 l-h-n h6 d-block">This month new shop</small>
                    </a>
                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>

        </div>

       <!--  <div class="col-sm-3 col-xl-3">

        <div class="col-sm-2 col-xl-2" style="margin-left:-33px;">
                    <a href="{{ url('dashboard/details', 'NotRefill') }}"
                        class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{ $not_refil_racks }} </span>
                        <small class="m-0 l-h-n h5 d-block">NOT NEED TO REFILL</small>
                    </a>


                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>

        </div> -->

        <!-- <div class="col-sm-3 col-xl-3">

            <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white mb-g">
                <div class="text-center">
                    <a href="{{ url('dashboard/details', 'NotRefill') }}"
                        class="display-4 d-block l-h-n m-0 fw-500 text-white">
                        <span class="font-weight-bold"> {{-- $not_refil_racks --}} </span>
                        <small class="m-0 l-h-n h5 d-block">This month product cost</small>
                    </a>


                </div>

                <i class="fa fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                    style="font-size:6rem"></i>
            </div>

        </div> -->
    </div>
    <!-- Card Section End -->



<div class="panel-container show">
    <div class="panel-content">
        <div class="row">
            <!--  Due Bill Collection  -->
            <div class="col-md-6">
                <h2> <span class="text-uppercase text-danger font-weight-bold">Due shop list </span></h2>
                <hr class="bg-danger">
                <table
                    class="table table-bordered table-hover table-striped table-sm w-100 dataTable bg-danger text-white">
                    <thead class="bg-primary-600">
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Rack Code</th>
                            <th>Contact Number</th>
                            <th>Last Payment</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl=1; @endphp
                        @foreach($previous_due_result as $single_result)
                      
                       <tr >
                            <td>{{ $sl++ }}</td>
                            <td onclick="ShowDetails(' {{ $single_result->shop_id }}', '{{ $single_result->rack_code }}')" >{{ $single_result->shop_name }}</td>
                            <td style="text-decoration:underline;cursor:pointer;" onclick="show_socks('{{ $single_result->rack_code}}')">{{ $single_result->rack_code}}</td>
                            <td>{{ $single_result->shop_contact }}</td>
                            <td>{{ $single_result->last_billing_date ? date('Y-m-d', strtotime($single_result->last_billing_date)) : 'Not Payment'  }} </td>
                            <td>{{ number_format($single_result->total_bill, 2) }} /=</td>                            
                        </tr>
                       
                       
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--  Due Bill Collection  -->

            <!--  Rack Refill  -->
            <div class="col-md-6">
                <h2> <span class="text-uppercase text-danger font-weight-bold">Refill shop list </span></h2>
                <hr class="bg-danger">
                <table
                    class="table table-bordered table-hover table-striped table-sm w-100 dataTable bg-danger text-white">
                    <thead class="bg-primary-600">
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Rack Code</th>
                            <th>Contact Number</th>
                            <th>Sold Socks</th>
                            <th>Last Update Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl=1; @endphp
                        @foreach($refill_result as $single_result)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td onclick="ShowDetails(' {{ $single_result->shop_id }}', '{{ $single_result->rack_code }}')">{{ $single_result->shop_name}}</td>
                                <td style="text-decoration:underline;cursor:pointer;" onclick="show_socks('{{ $single_result->rack_code}}')">{{ $single_result->rack_code}}</td>
                                <td>{{ $single_result->shop_contact }}</td>
                                <td>{{ $single_result->sold_socks_sell}} Pair</td>
                                <td>{{ $single_result->last_update_days_count}} days ago</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="col-md-6" style="display:none">      
                <h2> <span class="text-uppercase text-danger font-weight-bold"> Total Shop Bill Collection</span></h2>
                <table class="table table-bordered table-hover table-striped table-sm w-100 dataTable bg-success text-white">
                    <thead class="bg-primary-600">
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Rack code</th>
                            <th>Contact Number</th>
                            <th>Due</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl=1; @endphp
                        @foreach($total_bill_collecton_result as $single_result)
                        <tr onclick="ShowDetails(' {{ $single_result->shop_id }}', '{{ $single_result->rack_code }}')">
                            <td>{{ $sl++ }}</td>
                            <td>{{ $single_result->name}}</td>
                            <td>{{ $single_result->rack_code}}</td>
                            <td>{{ ($single_result->contact_no)? $single_result->contact_no : $single_result->owner_contact }}</td>
                            <td>{{ number_format($single_result->due_bill, 2) }} /=</td>                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--  Rack Refill  -->

            <!--this   Bill colleection   -->
            <div class="col-md-6 mt-5" style="display:none">
                <h2> <span class="text-uppercase text-danger font-weight-bold"> This month Bill Collection</span></h2>
                <hr class="bg-danger">
                <table
                    class="table table-bordered table-hover table-striped table-sm w-100 dataTable bg-success text-white">
                    <thead class="bg-primary-600">
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Rack Code</th>
                            <th>Contact Number</th>
                            <th>Total Shocs </th>
                            <th>Total Bill </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl=1; @endphp
                        @foreach($this_month_bill_collection_result as $single_result)
                        <tr onclick="ShowDetails(' {{ $single_result->shop_id }}', '{{ $single_result->rack_code }}')">
                            <td>{{ $sl++ }}</td>
                            <td>{{ $single_result->name}}</td>
                            <td>{{ $single_result->rack_code}}</td>
                            <td>{{ ($single_result->contact_no)? $single_result->contact_no : $single_result->owner_contact }}</td>
                            <td>{{ $single_result->total_socks}} Pair</td>
                            <td>{{ number_format($single_result->total_bill, 2) }} /=</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--  this   Bill colleection  -->


            <!--  Rack Refill  -->
            <div class="col-md-6 mt-5 offset-3" style="display:none">
                <h2> <span class="text-uppercase text-danger font-weight-bold"> This month New shop </span></h2>
                <hr class="bg-danger">
                <table
                    class="table table-bordered table-hover table-striped table-sm w-100 dataTable bg-success text-white">
                    <thead class="bg-primary-600">
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Rack Code</th>
                            <th>Contact Number</th>
                            <th>Total Shocs </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl=1; @endphp
                        @foreach($this_month_new_shop_result as $single_result)
                        <tr onclick="ShowDetails(' {{ $single_result->shop_id }}', '{{ $single_result->rack_code }}')">
                            <td>{{ $sl++ }}</td>
                            <td>{{ $single_result->name}}</td>
                            <td>{{ $single_result->rack_code}}</td>
                            <td>{{ ($single_result->contact_no)? $single_result->contact_no : $single_result->owner_contact }}</td>
                            <td>{{ $single_result->total_socks}} Pair</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--  Rack Refill  -->


<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="shopDetails" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"> <span class="text-danger text-uppercase font-weight-bold"> Shop Details </span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0">
                <table
                    class="table table-bordered table-hover table-striped table-sm w-100 dataTable  text-dark">
                   
                    <tbody>
                       
                        
                        <tr>
                            <td><span>Name  </span></td>
                            <td><span id="shop_name"></span></td>
                        </tr>
                        <tr>
                            <td><span>Rack code  </span></td>
                            <td><span id="rack_code"></span></td>
                        </tr>
                        <tr>
                            <td><span>Agent Name  </span></td>
                            <td><span id="agent_name"></span></td>
                        </tr>
                        <tr>
                            <td><span>Address  </span></td>
                            <td><span id="address"></span></td>
                        </tr>
                        <tr>
                            <td><span>Area  </span></td>
                            <td><span id="area"></span></td>
                        </tr>

                        <tr>
                            <td><span>contact  </span></td>
                            <td><span id="contact"></span></td>
                        </tr>
                        
                    </tbody>
                </table>
      </div>
    </div>
  </div>
</div>
<!-- Button trigger modal -->


        </div>

    </div>
</div>



<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"> Socks Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="show_data">
       
      </div>
      <div class="modal-footer">
       
       
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="_token" value="{{ csrf_token() }}">

@endsection


@push('js')

<script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/notifications/toastr/toastr.js') }}"></script>

<script>
/*data table script*/

$(document).ready(function() {

    // initialize datatable
    $('.dataTable').dataTable({
        responsive: true,
        lengthChange: false,
        dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
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
                extend: 'print',
                text: 'Print',
                titleAttr: 'Print Table',
                className: 'btn-outline-primary btn-sm'
            }
        ],

        "lengthMenu": [
            [10, 500, 100, -1]
        ]
    });

});

/*data table script*/
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
                    if(data.contact_no != '')
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