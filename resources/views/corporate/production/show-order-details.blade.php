@extends('layouts.app')
@section('title','Shops List')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">
 <link rel="stylesheet" href="{{ asset('public/backend/assets/css/notifications/toastr/toastr.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Bill</li>
            <li class="breadcrumb-item active"> Bill Authorize </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>



        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-8">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                    Bill Authorize    for [ {{ $order_info->client_name }} ]
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
                                <table class="table table-bordered table-hover table-striped table-sm w-100 text-center dataTable">
                                    <thead class="bg-primary-600">
                                        <tr>
                                            <td>SL</td>
                                            <th>PRODUCT NAME</th>                                                        
                                            <th>DESCRIPTION</th>
                                            <th>COLOR / DESIGN</th>
                                            <th>PER LOT QTY</th>
                                            <th>TOTAL QTY</th>
                                            <th>CPU</th>
                                            <th>COST AMOUNT</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                        $sl=1;
                                        $grand_total_qty=0;
                                        $grand_total_amt=0;
                                        @endphp
                                        @foreach($product_info as $single_info)
                                        
                                        @php
                                            $grand_total_qty += $single_info->total_qty ;
                                            $grand_total_amt += $single_info->total_amt;
                                        @endphp

                                        <tr>
                                            <td>{{ $sl++ }}</td>
                                            <td>{{ $single_info->product_name }}</td>
                                            <td>{{ $single_info->types_name }}</td>
                                            <td>{{ $single_info->color_qty }}</td>
                                            <td>{{ $single_info->lot_qty }}</td>
                                            <td>{{ $single_info->total_qty }}</td>
                                            <td>{{ number_format($single_info->single_price, 2) }}</td>
                                            <td>{{ number_format($single_info->total_amt, 2) }}</td>
                                        </tr>
                                        @endforeach
                                       	                                                 
                                    </tbody>
                                    <tfoot>
                                        <tr>
        
                                            <th style="text-align: center" colspan="5">TOTAL</th>
                                            <th>{{ number_format($grand_total_qty, 2) }}</th>
                                            <th></th>
                                            <th>{{ number_format($grand_total_amt, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                  
                                </table>
                                <!-- datatable end -->
                                
                            </div>
                        </div>
                    </div>

                <!-- data table -->
            </div>

            <div class="col-xl-4 col-md-4 col-sm-4">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                         <h2> Bill Authorize </h2>
                    </div>

                    <div class="panel-container show">
                            <div class="panel-content">
                            <form action="" method="post" id="corporate_auth">
                                @csrf

                                <table class="table table-bordered">

                                   

                                   <tr>
                                       <td colspan="2">
                                        <b>Total Product : </b>
                                        <span   > {{ $order_info->total_product }}</span>
                                        
                                       </td>
                                   </tr>

                                   <tr>
                                    <td colspan="2">
                                     <b>Total Bill : </b>
                                     <span   >{{ $order_info->total_bill }}</span>
                                     
                                    </td>
                                 </tr>

                                 <tr>
                                    <td colspan="2">
                                     <b>Order Date : </b>
                                     <span   >{{ $order_info->order_date }}</span>
                                     
                                    </td>
                                 </tr>

                                 <tr>
                                    <td colspan="2">
                                     <b>Status : </b>
                                     @php
                                        switch ($order_info->status) {
                                            case '1':
                                                    $sts= "Pending";
                                                break;
                                            case '2':
                                                    $sts= "Production";
                                                break;
                                            
                                            case '3':
                                                    $sts= "Delivery";
                                                break;
                                            case '4':
                                                    $sts= "Partial Payment";
                                                break;
                                            case '5':
                                                    $sts= "Full Payment";
                                                break;
                                            default:
                                                $sts = "Not found";
                                                break;
                                        }
                                    @endphp
                                     <span>{{ $sts}}</span>
                                     
                                    </td>
                                 </tr>

                                 <tr>
                                    <td colspan="2">
                                     <b>Remarks : </b>
                                     <span> {{ $order_info->remarks }} </span>
                                     
                                    </td>
                                 </tr>


                                 <tr>
                                    <td colspan="2">
                                     <b>Status : </b>
                                    <select name="sts" id="sts" class="form-control select2" required>
                                        <option value="">Select Status</option>
                                       @if($order_info->status < 3)
                                        <option {{ ($order_info->status == 2 ) ?'disabled': ''  }} value="2">Production</option>
                                        <option {{ ($order_info->status == 3 ) ?'disabled': ''  }}  value="3">Delivery</option>  
                                      @endif
                                    </select>
                                     
                                    </td>
                                 </tr>


                                </table>

                               
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="validationCustom01">Remarks <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="remarks" placeholder="Give Remarks" required >
                                         <div class="invalid-feedback">
                                             Please provide a valid brand.
                                         </div>
                                     </div>
                                </div>
                                <input type="hidden" name="chalan_no" value="{{ Crypt::encrypt($order_info->challan_no) }}" id="chalan_no">
                                <button class="btn btn-primary ml-auto" id="disableButton" type="submit">Authorize</button>
                           
                            </form> 

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
 <script src="{{ asset('public/backend/assets/js/notifications/toastr/toastr.js') }}"></script>

    <script>

    /*data table script*/

     $(document).ready(function()
            {

                // initialize datatable
                $('#dt-basic-example').dataTable(
                {
                    responsive: true,
                    lengthChange: false,
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
                        
                    ]
                });

            });

    /*data table script*/
    </script>


<script>
	$(function() {
            var $form = $(this);
            $.validator.setDefaults({
                errorClass: 'help-block',
                highlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .removeClass('has-error');
                }
            });

        

            $("#corporate_auth").validate({
                rules: {
                    remarks: { required: true},
                    sts : {required: true}
                    
                },
                submitHandler: function(form) {
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? want to this authorize",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('corporate.Order.confrim.auth') }}',
                                data: $(form).serialize(),
                                beforeSend: function() {
                                    loaderStart();
                                },
                                success: (data) => {
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
                                            message   :  data.message,
                                            buttonText: "ok"
                                        })


                                    }else{

                                        alert(data.message);                                        
                                    }

                                    console.log(data)
                                                         
                                },
                                error: function(data) {
                                 
                                },
                                complete: function() {
                                    loaderEnd();
                                }
                            });
                            $form.submit();
                        }
                    })
                }
            });
        });
</script>





    
@endpush


