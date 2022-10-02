@extends('layouts.app')
@section('title', 'Corporate')
@section('content')

 <ol class="breadcrumb page-breadcrumb">
	    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
	    <li class="breadcrumb-item">Coporate</li>
	    <li class="breadcrumb-item active">Create Coporate Order</li>
	    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
	</ol>

<form class="needs-validation" novalidate action="{{ route('corporate.Order.store') }}" method="post" id="stockForm">

<div class="col-md-08">
	 <div id="panel-2" class="panel">
	    <div class="panel-hdr">
	        <h2>
	              <span class="fw-300"><i> Create Coporate Order</i></span>
	        </h2>
	        <div class="panel-toolbar">
	            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
	            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
	            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
	        </div>
           {{--  <div class="col-md-3" >
                <h2 style="float: right;">Client Name</h2>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label" for="validationCustom03"> </label>
                <select class="select2 custom-select"    name="client_name" id="client_name" required="">
                    <option value="">Select  Client</option>
                    @foreach($clients as $single_client)
                    <option value="{{ $single_client->id }}">{{ $single_client->client_name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Please provide a valid  Packet quenty.
                </div>
            </div> --}}

            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-4 form-label mt-2" for="validationCustom03"> Client Name <span class="text-danger">*</span> </label>
                    <div class="col-md-7">
                        <select class="select2 custom-select"    name="client_name" id="client_name" required="">
                            <option value="">Select  Client</option>
                            @foreach($clients as $single_client)
                            <option value="{{ $single_client->id }}">{{ $single_client->client_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid  Packet quenty.
                        </div>
                    </div>
                  </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-4 form-label mt-2" for="validationCustom03"> Order No <span class="text-danger">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="order_no" placeholder="Order No" required>
                        <div class="invalid-feedback">
                            Please provide a valid  Packet quenty.
                        </div>
                    </div>
                  </div>
            </div>
	       

	    </div>


        <style>
            
        </style>



    <div class="panel-container show">
        <div class="panel-content p-0">

            
            
            	@csrf
                <div class="panel-content">
                	<div id="parent-product">
                	
	                	<div class="single-product">
	                   		 <div class="form-row">
			                        <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom01">Product Name <span class="text-danger">*</span></label>
			                           <input type="text" class="form-control" name="product_name[0]" placeholder="Product Name" required>
			                            <div class="invalid-feedback">
			                                Please provide a valid brand.
			                            </div>
			                        </div>

			                        <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom">Description / Type <span class="text-danger" >*</span></label>
			                          
                                       <select name="type_name[0]" id="" class="form-control select2" required>
                                            <option value="">Select Type</option>
                                            @foreach($types as $single_type)
                                            <option value="{{ $single_type->id }}">{{ $single_type->types_name }}</option>
                                            @endforeach
                                       </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid type.
			                            </div>
			                        </div>

                                   


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="validationCustom">Color / Design Quantity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control color_qty_0" onkeyup="TotalQuantity(0)"  name="color_qty[0]" placeholder="Color Quantity" required>
                                         <div class="invalid-feedback">
                                             Please provide a valid type.
                                         </div>
                                     </div>

                                    

                                     <div class="col-md-4 mb-3">
                                        <label class="form-label" for="validationCustom">Lot Quantity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control lot_qty_0" onkeyup="TotalQuantity(0)" name="lot_qty[0]" placeholder="Lot Quantity" required>
                                         <div class="invalid-feedback">
                                             Please provide a valid type.
                                         </div>
                                     </div>


                                   

			                        <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom03"> Total quenty <span class="text-danger">*</span></label>
			                             <input type="number" readonly class="form-control total_qty_0"   name="total_qty[0]" id="validationCustom02" placeholder="Total Quenty"  required>
			                            <div class="invalid-feedback">
			                                Please provide a valid Per Packet quenty.
			                            </div>
			                        </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="validationCustom03">Single Price <span class="text-danger">*</span></label>
                                         <input type="number"  class="form-control single_price_0" onkeyup="Totalprice(0)" name="single_price[0]" placeholder="Single Price">
                                     </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="validationCustom03"> Total Price <span class="text-danger">*</span></label>
                                          <input type="number" readonly class="form-control total_price_0" onkeyup="Totalprice(0)"  name="total_price[0]" id="validationCustom02" placeholder="Total Price"  required>
                                         <div class="invalid-feedback">
                                             Please provide a valid Per Packet quenty.
                                         </div>
                                     </div>
			                        

	                        </div> 
                	</div>{{-- end-single-product --}}
                    <div class="show-singlw-row">

                    </div>

                </div>

                <button class="btn btn-primary ml-auto" id="disableButton" type="submit">Submit form</button>

                <button type="button" style="float: right; margin-right: 10px; " class="btn btn-success ml-auto" id="addMore" type="submit">Add More</button>
           
            
        </div>
    </div>
</div>
</div>
 </form>

@endsection

@push('js')
<script src="{{ asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script>

$(document).ready(function(){

	$('.select2').select2();	
});
</script>


<script>
    /*lon number select */

    $(document).ready(function(){

        var client_id = $('#client_name').val();

        if(client_id =='')
        {
            $('.panel-container').hide();
        }else{
            $('.panel-container').show();
        }

    });


    $('#client_name').change(function(){

        var client_id = $('#client_name').val();

        if(client_id =='')
        {
            $('.panel-container').hide();
        }else{
            $('.panel-container').show();
        }

    });
</script>

<!-- add more script -- -->



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

        

            $("#stockForm").validate({
                rules: {
                    client_name: { required: true},
                    
                },
                submitHandler: function(form) {

                    var base_url = window.location.origin + '/vll/';
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? Place this order",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('corporate.Order.store') }}',
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

<script>
    var i=0;
    $('#addMore').click(function(){
       ++i;
        var index_no = i;
       $.ajax({
            type:'POST',
            url:"{{ route('corporate.Order.single_row') }}",
            data: {index_no: index_no, '_token': "{{ csrf_token() }} "},
            success:function(data)
            {
               $('.show-singlw-row').append(data);
               $('.select2').select2();
               
            }


       }); 

    });

   

    $(document).on('click', '.remove-div', function(){  
        $(this).parents('.content-div').remove();
    }); 

   
    
</script>
{{-- quantity summation --}}
<script>
    function  TotalQuantity(index_no)
    {
        var color_qty = $('.color_qty_'+index_no).val();
        var lot_qty = $('.lot_qty_'+index_no).val();

        var total_qty = parseInt(color_qty) * parseInt(lot_qty);
        $('.total_qty_'+index_no).val(parseInt(total_qty));
        Totalprice(index_no)
    }


    function  Totalprice(index_no)
    {
        
        var single_price = $('.single_price_'+index_no).val();
        var total_qty = $('.total_qty_'+index_no).val();

        var total_price = parseFloat(single_price) * parseInt(total_qty);
        $('.total_price_'+index_no).val(parseFloat(total_price).toFixed(2));
    }
</script>








@endpush