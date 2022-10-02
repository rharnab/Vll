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
body{
    font-size: 30px;
}

.count {
    border: 2px solid #505050 ;
    border-radius: 1rem;
    padding: 5px 18px;
    /*background-color: #fd3995;*/
    font-weight: bold;
}
.count_text {
    font-size: 3rem;
}



</style>

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@section('content')

<div class="panel-container show">
    <div class="panel-content">

        <div class="row">
            <!--  Due Bill Collection  -->
            <div class="col-md-12 col-xs-12">

                <div class="row">
                        <div class="col-md-6">
                             <h2 class="count_text"> <span class="text-uppercase text-dark font-weight-bold">Due shop  </span></h2>
                        </div>
                         <div class="col-md-6">
                             <h2 class="count_text"> <span class="text-uppercase text-danger float-right count bg-dark"> {{ count($previous_due_result) }} </span></h2>
                        </div>
                    
                </div>
                
                <hr class="bg-danger">
                <table
                    class="table table-bordered table-hover table-striped table-sm w-100 dataTable bg-dark text-white text-center">
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
            <div class="col-md-12 col-xs-12 mt-4">

                 <div class="row">
                        <div class="col-md-6">
                              <h2 class="count_text"> <span class="text-uppercase text-dark font-weight-bold"> Refill Shop  </span></h2>
                        </div>
                         <div class="col-md-6">
                             <h2 class="count_text"> <span class="text-uppercase text-danger float-right count bg-dark"> {{ count($refill_result) }} </span></h2>
                        </div>
                    
                </div>

               
                <hr class="bg-danger">
                <table
                    class="table table-bordered table-hover table-striped table-sm w-100 dataTable bg-dark text-white text-center">
                    <thead class="bg-primary-600">
                        <tr>
                            <th>Name</th>
                            <th>Rack Code</th>
                            <th>Contact Number</th>
                            <th>Sold Socks</th>
                            <th>Last Visit</th>
                            <th>Visit Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $sl=1; @endphp
                        @foreach($refill_result as $single_result)
                            <tr>
                                <td onclick="ShowDetails(' {{ $single_result->shop_id }}', '{{ $single_result->rack_code }}')">{{ $single_result->shop_name}}</td>
                                <td style="text-decoration:underline;cursor:pointer;" onclick="show_socks('{{ $single_result->rack_code}}')">{{ $single_result->rack_code}}</td>
                                <td>{{ $single_result->shop_contact }}</td>
                                <td>{{ $single_result->sold_socks_sell}} Pair</td>
                                <td>{{ $single_result->last_update_days_count}}</td>
                                <td>{{ ($single_result->last_update_date)? $single_result->last_update_date: '-' }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            
            
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
        "searching": false,
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

<script>
    setInterval(function() {window.location.reload()}, 300000);
</script>

@endpush