@extends('layouts.app')
@section('title','Modify Corporate Order')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item">Modify Corporate Order</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-5 col-md-5 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>Modify Corporate Order </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form id="" action="{{ route('corporate.bill.bill_store') }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="shop">Select Client</label>

                                    <select name="client_id" id="client_id" class="form-control select2" required>
                                        <option value="">--select--</option>
                                        @foreach($all_due_client as $single_client)
                                        <option value="{{$single_client->client_id}}">{{$single_client->client_name}}</option>
                                        @endforeach

                                    </select>
                                    <div class="valid-feedback">
                                    </div>
                                </div>

                            </div>


                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="challan_no">Challan No.</label>

                                    <select name="challan_no" id="challan_no" class="form-control select2" required>
                                        <option value="">--select--</option>

                                    </select>
                                    <div class="valid-feedback">
                                    </div>
                                </div>

                            </div>
                
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-md-7 ">
            <div id="panel-3" class="panel">
                <div id="result"></div>
            </div>
        </div>


    </div>

      {{--------------- edit screen field------------------------ --}}
    <div class="row">
        <div class="col-xl-12 col-md-12 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>Add Another  Order  </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form id="stockForm" action="{{ route('corporate.Order.addProduct') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="panel-container show">
                                <div class="panel-content p-0">

                                    @csrf
                                    <div class="panel-content">
                                     
                                        <div id="parent-product">
                                            <div class="show-singlw-row">

                                            </div>
                                            <div class="single-product">
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="product_name">Product Name <span class="text-danger">*</span></label>


                                                        <select name="product_name" class="select2 form-control" onchange="getProductSize()" id="product_name" required>
                                                            <option value="">Select Product Type</option>
                                                            @foreach($categories as $val)
                                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid brand.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="type_name">Size <span class="text-danger">*</span></label>

                                                        <select name="type_name" class="form-control select2" id="type_name" required>
                                                            <option value="">Select Type</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid type.
                                                        </div>
                                                    </div>




                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="total_qty"> Total quenty <span class="text-danger">*</span></label>
                                                        <input type="number" id="total_qty" class="form-control total_qty" onkeyup="TotalByPrice()" onkeyup="TotalSalePrice()" name="total_qty" placeholder="Total Quenty" required>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Per Packet quenty.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="buing_unit_price">Buying Unit Price <span class="text-danger">*</span></label>
                                                        <input type="number" id="buing_unit_price" class="form-control buing_unit_price" onkeyup="TotalByPrice()" name="buying_unit_price" placeholder="Buy Price" required>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="total_buying_price"> Total Buying Price <span class="text-danger">*</span></label>
                                                        <input type="number" readonly id="total_buying_price" class="form-control total_buying_price" name="total_buying_price" placeholder="Total Buy Price" required>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Per Packet quenty.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="selling_unit_price">Selling Unit Price <span class="text-danger">*</span></label>
                                                        <input type="number" id="selling_unit_price" class="form-control selling_unit_price" onkeyup="TotalSalePrice()" name="selling_unit_price" placeholder="Sale Price" required>
                                                    </div>



                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="total_selling_price"> Total selling Price <span class="text-danger">*</span></label>
                                                        <input type="number" readonly class="form-control total_selling_price" id="total_selling_price" name="total_selling_price" placeholder="Total Sale Price" required>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid Per Packet quenty.
                                                        </div>
                                                    </div>


                                                    <input type="hidden" id="add_challan_no" name="add_challan_no">

                                                </div>
                                            </div>{{-- end-single-product --}}


                                        </div>

                                        <button class="btn btn-primary ml-auto" id="disableButton" type="submit">Submit form</button>




                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--------------- edit screen field------------------------ --}}

</main>

@endsection

@push('js')

<script>
    $('#client_id').on('change', function() {
        var client_id = $("#client_id").val();

        $("#total_amount").val('');
        $("#paid_amount").val('');
        $("#due_amount").val('');
        $("#bill_collection_amount").val('');

        if (client_id != '') {

            $.ajax({
                type: "POST"
                , url: "{{ route('corporate.Order.challan_no') }}"
                , data: {
                    client_id: client_id
                    , "_token": " {{ csrf_token() }} "
                , }
                , success: function(data) {

                    $("#challan_no").html(data);
                    //console.log(data);

                }
            });



        }
    })

</script>


<script>
    $("#challan_no").on("change", function() {

        var client_id = $("#client_id").val();
        var challan_no = $("#challan_no").val();


        $.ajax({
            type: "POST"
            , url: "{{ route('corporate.Order.details') }}"
            , data: {
                client_id: client_id
                , challan_no: challan_no
                , "_token": " {{ csrf_token() }} "
            , }
            , success: function(data) {

                $('#result').html(data);

            }
        });
    });

</script>



{{-- edit screeen script add --}}

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
//find out product size
function getProductSize()
{
   var product_type =  $('#product_name').val();
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


<script>

    //number validator
    $.validator.addMethod('number', function(value) {
            //return /^\d+$/.test(value);
            return /^\d+(\.\d{1,2})?$/.test(value);
        }, 'Please enter Only number');


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

        

            $("#stockForm").validate({
                rules: {
                    client_name: { required: true},
                    product_name: { required: true},
                    type_name: { required: true},
                    total_qty: { required: true, number: true},
                    buing_unit_price: { required: true, number: true},
                    total_buying_price: { required: true, number: true},
                    selling_unit_price: { required: true, number: true},
                    total_selling_price: { required: true, number: true},
                    
                },
                submitHandler: function(form) {

                    var base_url = window.location.origin + '/';

                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? Place this order",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{

                       var challan_no =  $('#challan_no').val();
                        $("#add_challan_no").val(challan_no);



                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('corporate.Order.addProduct') }}',
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
                                            window.location = base_url+'corporate/order/show_voucher/'+data.chalan_no
                                           // window.location.href= "{{ route('factory.bill.voucher.list') }}"
                                            //location.reload(true);
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

                                    //console.log(data)
                                                         
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



{{-- edit screeen script add --}}

@endpush
