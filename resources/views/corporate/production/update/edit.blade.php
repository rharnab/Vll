@extends('layouts.app')
@section('title','Modify Sale')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item active">Modify Corporate Sale</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Modify Corporate Sale</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('corporate.bill.bill_store') }}" method="post" enctype="multipart/form-data" >

                                @csrf

                            
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="shop">Client Name</label>
                                        <span class="form-control">{{ $order_info->client_name }}</span>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="challan_no">Challan No.</label>
                                        <span class="form-control">{{ $order_info->challan_no }}</span>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="product_id">Product Name <span class="text-danger">*</span></label>
                                   

                                    <select name="product_id" class="select2 form-control"  onchange="getProductSize()" id="product_id" required>
                                        <option value="">Select Product Type</option>
                                        @foreach($categories as $val)
                                            @if($val->id == $order_info->product_type )
                                            <option selected value="{{ $val->id }}">{{ $val->name }}</option>
                                            @else
                                            <option  value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                     <div class="invalid-feedback">
                                         Please provide a valid brand.
                                     </div>
                                 </div>

                                 <div class="col-md-12 mb-3">
                                    <label class="form-label" for="type_name">Size <span class="text-danger" >*</span></label>
                                   
                                    <select name="type_name"  class="form-control select2" id="type_name" required>
                                         <option value="">Select Type</option>
                                         @foreach($types as $single_type)
                                            @if($single_type->id == $order_info->type_id )
                                            <option selected value="{{ $single_type->id }}">{{ $single_type->types_name }}</option>
                                            @else
                                            <option selected value="{{ $single_type->id }}">{{ $single_type->types_name }}</option>
                                            @endif
                                         @endforeach
                                    </select>
                                     <div class="invalid-feedback">
                                         Please provide a valid type.
                                     </div>
                                 </div>

                                


                                 <div class="col-md-12 mb-3">
                                    <label class="form-label" for="total_qty"> Total quenty <span class="text-danger">*</span></label>
                                      <input type="number" id="total_qty" value="{{ $order_info->total_qty }}" onkeyup="TotalByPrice()"  class="form-control total_qty" onkeyup="TotalByPrice()"  onkeyup="TotalSalePrice()"  name="total_qty"  placeholder="Total Quenty"  required>
                                     <div class="invalid-feedback">
                                         Please provide a valid Per Packet quenty.
                                     </div>
                                 </div>

                                 <div class="col-md-12 mb-3">
                                     <label class="form-label" for="buing_unit_price">Buying Unit Price <span class="text-danger">*</span></label>
                                      <input type="number" id="buing_unit_price" value="{{ $order_info->unit_buy_price }}"   class="form-control buing_unit_price" onkeyup="TotalByPrice()"  name="buying_unit_price" placeholder="Buy Price" required>
                                  </div>

                                  <div class="col-md-12 mb-3">
                                     <label class="form-label" for="total_buying_price"> Total Buying Price <span class="text-danger">*</span></label>
                                       <input type="number" readonly id="total_buying_price" value="{{ $order_info->total_buy_amt }}" class="form-control total_buying_price"   name="total_buying_price"  placeholder="Total Buy Price"  required>
                                      <div class="invalid-feedback">
                                          Please provide a valid Per Packet quenty.
                                      </div>
                                  </div>

                                  <div class="col-md-12 mb-3">
                                  </div>

                                 <div class="col-md-12 mb-3">
                                     <label class="form-label" for="selling_unit_price">Selling Unit Price <span class="text-danger">*</span></label>
                                      <input type="number"  id="selling_unit_price" value="{{ $order_info->unit_sale_price }}" class="form-control selling_unit_price" onkeyup="TotalSalePrice()"  name="selling_unit_price" placeholder="Sale Price" required>
                                  </div>

                                  

                                 <div class="col-md-12 mb-3">
                                     <label class="form-label" for="total_selling_price"> Total selling Price <span class="text-danger">*</span></label>
                                       <input type="number" readonly class="form-control total_selling_price" value="{{ $order_info->total_sale_amt }}" id="total_selling_price"   name="total_selling_price"  placeholder="Total Sale Price"  required>
                                      <div class="invalid-feedback">
                                          Please provide a valid Per Packet quenty.
                                      </div>
                                  </div>

                                  <input type="hidden" value="{{ Crypt::encrypt($order_info->id) }}" name="sale_id" id="sale_id">
                                  <input type="hidden" value="{{ Crypt::encrypt($order_info->challan_no) }}" name="challan_no" id="challan_no">


                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="button">update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
 
@endsection

@push('js')


<script>
    //find out product size
    function getProductSize()
    {
       var product_type =  $('#product_id').val();
       $.ajaxSetup({
            'headers': {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }    
        });
    
        if(product_type !='')
        {
            $.ajax({
                "type": 'post',
                "url" : '{{ route('corporate.Order.getProductSize') }}',
                "data": {'product_type': product_type},
                "success":function(data)
                {
                    $('#type_name').empty().append(data);
                    
                }
            })
        }
        
    }
    </script>


{{-- quantity summation --}}
<script>



    //buy price  calculate
    function  TotalByPrice()
    {
        
        var buy_price = $('.buing_unit_price').val();
        var total_qty = $('.total_qty').val();

        var total_price = parseFloat(buy_price) * parseInt(total_qty);
        $('.total_buying_price').val(parseFloat(total_price).toFixed(2));

        TotalSalePrice();
    }
    //sale price calculate
    function  TotalSalePrice()
    {
        
        var sale_price = $('.selling_unit_price').val();
        var total_qty = $('.total_qty').val();

        var total_price = parseFloat(sale_price) * parseInt(total_qty);
        $('.total_selling_price').val(parseFloat(total_price).toFixed(2));

       
    }
</script>


<script>
    $(".submit_btn").on("click", function(){

        var base_url = window.location.origin + '/';


        var sale_id = $("#sale_id").val();
        var product_id = $("#product_id").val();
        var type_name = $("#type_name").val();
        var total_qty = $("#total_qty").val();
        var buing_unit_price = $("#buing_unit_price").val();
        var total_buying_price = $("#total_buying_price").val();
        var selling_unit_price = $("#selling_unit_price").val();
        var total_selling_price = $("#total_selling_price").val();
        var challan_no = $("#challan_no").val();


            cuteAlert({
            type: "question",
            title: "Confirm Title",
            message: "Do you want update this order ??",
            confirmText: "Okay",
            cancelText: "Cancel"
            }).then((e)=>{
               
            if ( e == ("confirm")){
                
                $.ajax({
                type:"POST",
                url:"{{ route('corporate.Order.update') }}",
                data:{
                    sale_id: sale_id,
                    product_id: product_id,
                    type_name: type_name,
                    total_qty: total_qty,
                    buing_unit_price: buing_unit_price,
                    selling_unit_price : selling_unit_price,
                    challan_no : challan_no,
                    total_buying_price: total_buying_price,
                    total_selling_price: total_selling_price,
                    "_token": " {{ csrf_token() }} ",
                },
                success:function(data)
                {
                    if(data.status == 200)
                    {
                        cuteAlert({
                        type      : "success",
                        title     : "success",
                        message   : data.message,
                        
                        })
                        .then((e)=>{
                            //location.reload(true);
                            //window.location.href= "{{ route('factory.bill.voucher.list') }}"
                            window.location = base_url+'corporate/order/show_voucher/'+data.chalan_no
                        })
                    }else{
                        
                        cuteAlert({
                            type      : "danger",
                            title     : "warning",
                            message   : data.message,
                        
                        })
                        
                    }

                    console.log(data)
                    
                }
            });

            }
            })


           

    });

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

        });
    </script>

@endpush
