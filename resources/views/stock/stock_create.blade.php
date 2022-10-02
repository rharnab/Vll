@extends('layouts.app')
@section('content')

 <ol class="breadcrumb page-breadcrumb">
	    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
	    <li class="breadcrumb-item">Stock</li>
	    <li class="breadcrumb-item active">Create</li>
	    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
	</ol>

<form class="needs-validation" novalidate action="{{ route('stock.store') }}" method="post" id="stockForm">

<div class="col-md-08">
	 <div id="panel-2" class="panel">
	    <div class="panel-hdr">
	        <h2>
	            Stock  <span class="fw-300"><i>Create</i></span>
	        </h2>
	        <div class="panel-toolbar">
	            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
	            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
	            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
	        </div>
	       
            <div class="col-md-1" >
                <h2 style="float: right;">Lot No</h2>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label" for="validationCustom03"> </label>
                <select class="select2 custom-select per_packet_quenty_0"    name="stock_lot" id="stock_lot" required="">
                    <option value="">SELECT LOT NO</option>

                    <option  value=" {{ $lot_no + 1 }} ">{{ $lot_no + 1 }}</option>
                    <option value=" {{ $lot_no }} ">{{ $lot_no }}</option>
                   
                </select>
                <div class="invalid-feedback">
                    Please provide a valid  Packet quenty.
                </div>
            </div>

             {{-- <button type="button" style="float: right; margin-right: 10px; " class="btn btn-success ml-auto" id="addMore" type="submit">Add More</button> --}}

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
			                           <label class="form-label" for="validationCustom01">Brand <span class="text-danger">*</span></label>
			                            <select class="select2 custom-select brand_check_0" name="addmore[0][brand]" required="" onchange="findTypeInfo(0)">
			                                <option value="">State Brand</option>
			                                @foreach($brands as $brand)
			                                 <option value=" {{ $brand->id }} ">{{ trim($brand->name) }}</option>
			                                @endforeach
			                            </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid brand.
			                            </div>
			                        </div>

			                        <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom">Type <span class="text-danger">*</span></label>
			                            <select class="select2 custom-select type_check_0" name="addmore[0][type]" required="" onchange="findSizeInfo(0)">
			                                <option value="">State Type</option>
			                                
			                            </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid type.
			                            </div>
			                        </div>

			                         <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom">Size <span class="text-danger">*</span></label>
			                            <select class="select2 custom-select size_check_0" name="addmore[0][size]" required="" onchange="Product_Check(0)">
			                                <option value="">State Size</option>
			                               
			                            </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid Size.
			                            </div>
			                        </div>

                                    

			                       <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom03">Per Packet quenty <span class="text-danger">*</span></label>
			                            <select class="select2 custom-select per_packet_quenty_0 product_checck_0"    name="addmore[0][per_pkt_qty]" required="" onchange="Product_Check(0)">
			                                <option value="">select Per Packet quenty</option>
			                                <option value="12">12</option>
			                                <option value="6">6</option>
			                               
			                            </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid  Packet quenty.
			                            </div>
			                        </div>
			                        
			                        <div class="col-md-4 mb-3">
                                        <label class="form-label" for="validationCustom03">Single Price <span class="text-danger">*</span></label>
                                         <input type="number" readonly class="form-control per_packet_price_0 product_checck_0" placeholder="Packet Price">
                                     </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="validationCustom03">Single Price <span class="text-danger">*</span></label>
                                         <input type="number" readonly class="form-control per_packet_price_0 product_checck_0" placeholder="Packet Price">
                                     </div>


			                        <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom03">Packet quenty <span class="text-danger">*</span></label>

			                             <input type="number" class="form-control"  name="addmore[0][pkt_qty]" id="validationCustom02" placeholder="Packet quenty"  required>
			                            <div class="invalid-feedback">
			                                Please provide a valid Per Packet quenty.
			                            </div>
			                        </div>
			                        

	                        </div> 
                	</div>{{-- end-single-product --}}

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

        var lot_no = $('#stock_lot').val();

        if(lot_no =='')
        {
            $('.panel-container').hide();
        }else{
            $('.panel-container').show();
        }

    });


    $('#stock_lot').change(function(){

        var lot_no = $('#stock_lot').val();

        if(lot_no =='')
        {
            $('.panel-container').hide();
        }else{
            $('.panel-container').show();
        }

    });

    

    
</script>

<!-- add more script -- -->
<script>
	var i =0;
	$('#addMore').click(function(){

		++i;
		$('#parent-product').append('<div class="content-div"> <div class="form-row"> <div class="col-md-11 mb-3"> <hr> </div> <div class="col-md-1 mb-3"> <button type="button" class="btn btn-danger remove-div">Remove</button> </div> </div></span>  <div class="single-product"> <div class="form-row"><div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom01">Brand <span class="text-danger">*</span></label>  <select class="select2 custom-select brand_check_'+i+' " name="addmore['+i+'][brand]" required="" onchange="findTypeInfo('+i+')"><option value="">State Brand</option>@foreach($brands as $brand)  <option value=" {{ $brand->id }} ">{{ trim($brand->name) }}</option>  @endforeach </select><div class="invalid-feedback">  Please provide a valid brand. </div> </div> <div class="col-md-4 mb-3"><label class="form-label" for="validationCustom"> Type <span class="text-danger">*</span></label>    <select class="select2 custom-select type_check_'+i+' " name="addmore['+i+'][type]" required="" onchange="findSizeInfo('+i+')"> <option value="">State Type</option>   </select> <div class="invalid-feedback"> Please provide a valid type. </div></div> <div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom">Size <span class="text-danger">*</span></label>   <select class="select2 custom-select size_check_'+i+' " name="addmore['+i+'][size]" required="" onchange="Product_Check('+i+')"> <option value="">State Size</option>  </select> <div class="invalid-feedback"> Please provide a valid Size. </div></div> <div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom03">Per Packet quenty <span class="text-danger">*</span></label>   <select class="select2 custom-select per_packet_quenty_'+i+' product_checck_'+i+' " name="addmore['+i+'][per_pkt_qty]" required="" onchange="Product_Check('+i+')"> <option value="">State Per Packet quenty</option> <option value="12">12</option> <option value="6">6</option> </select><div class="invalid-feedback"> </div></div> <div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom03">Single Price <span class="text-danger">*</span></label><input type="number" readonly class="form-control per_packet_price_'+i+' product_checck_'+i+'" placeholder="Single Price"></div> <div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom03">Packet quenty <span class="text-danger">*</span></label> <input type="number" class="form-control"  name="addmore['+i+'][pkt_qty]" id="validationCustom02" placeholder="Packet quenty"  required> <div class="invalid-feedback">  Please provide a valid Per Packet quenty. </div> </div></div></div> </div>');

        $('.select2').select2();
	});

	$(document).on('click', '.remove-div', function(){  


             $(this).parents('.content-div').remove();
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

        

            $("#stockForm").validate({
                rules: {
                    stock_lot: { required: true}
                },
                submitHandler: function(form) {
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? stock these product",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('stock.store') }}',
                                data: $(form).serialize(),
                                beforeSend: function() {
                                    loaderStart();
                                },
                                success: (data) => {
                                    if(data.status == 200){
                                        cuteAlert({
                                            type      : "success",
                                            title     : "Success",
                                            message   : "Product stock Added Sucessfully",
                                            buttonText: "ok"
                                        }).then((e)=>{
                                            location.reload(true);
                                        });
                                    }else if(data.status == 400){

                                        cuteAlert({
                                            type      : "warning",
                                            title     : "Warning",
                                            message   : "Sorry product type not match",
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

    /*existing product validation*/
    function Product_Check(id)
    {

       var per_pkt_qty =  $('.product_checck_'+id).val();
       var brand_check =  $('.brand_check_'+id).val();
       var type_check =  $('.type_check_'+id).val();
       var size_check =  $('.size_check_'+id).val();
       var error = 0;

       if(brand_check == '')
       {
            $('.brand_check_'+id).addClass('is-invalid');
            error =1;
       }else{
        $('.brand_check_'+id).removeClass('is-invalid');
       }

       if(type_check == '')
       {
            $('.type_check_'+id).addClass('is-invalid');
            error =1;
       }else{
        $('.type_check_'+id).removeClass('is-invalid');
       }

       if(size_check == '')
       {
            $('.size_check_'+id).addClass('is-invalid');
            error =1;
       }else{
        $('.size_check_'+id).removeClass('is-invalid');
       }


       if(error ==0 )
       {
         $.ajax({

            type:'POST',
            url : ' {{ route('stock.product-check') }}',
            data:{ '_token': " {{ csrf_token()  }} ",  'per_pkt_qty': per_pkt_qty, "brand_check": brand_check, "type_check": type_check, "size_check": size_check},
            success:function(response)
            {
                if(response.success==0)
                {
                    $('.brand_check_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "red" });
                    $('.size_check_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "red" });
                    $('.type_check_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "red" });
                    $('.product_checck_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "red" });


                }else{
                    $('.brand_check_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "#E5E5E5" });
                    $('.size_check_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "#E5E5E5" });
                    $('.type_check_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "#E5E5E5" });
                    $('.product_checck_'+id).siblings('.select2').find('.select2-selection').css({ "border-color": "#E5E5E5" });
                    $('.per_packet_price_'+id).val(response.sale_price);
                }
                console.log(response)

                

            }

         });
       }  

    }

</script>


<!-- Get type info   -->
<script>
   
        function findTypeInfo(id)
        {
            var brand_check =  $('.brand_check_'+id).val();
        
            if(brand_check !='')
            [
                $.ajax({
                    type:'post',
                    url: '{{ route('stock.type-info') }}',
                    data:{
                        'brand_id': brand_check,
                        'index_id' : id,
                        '_token' : "{{ csrf_token() }}"
                    },
                    beforeSend : function()
                    {
                        loaderStart();
                    },
                    success:function (data)
                    {   
                        $('.type_check_'+id).html(data);
                        console.log(data);
                        
                    },
                    complete: function()
                    {
                        loaderEnd();
                    }
                    
                })
            ]
           
        }

 
</script>




<!-- Get size info   -->
<script>
   
        function findSizeInfo(id)
        {
            var brand_check =  $('.brand_check_'+id).val();
            var type_check =  $('.type_check_'+id).val();
        
            if(brand_check !='' && type_check !='')
            [
                $.ajax({
                    type:'post',
                    url: '{{ route('stock.size-info') }}',
                    data:{
                        'brand_id': brand_check,
                        'type_id' : type_check,
                        'index_id' : id,
                        '_token' : "{{ csrf_token() }}"
                    },
                    beforeSend : function()
                    {
                        loaderStart();
                    },
                    success:function (data)
                    {   
                        $('.size_check_'+id).html(data);
                        console.log(data);
                        
                    },
                    complete: function()
                    {
                        loaderEnd();
                    }
                    
                })
            ]
           
        }

 
</script>




@endpush