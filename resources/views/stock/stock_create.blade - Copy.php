@extends('layouts.app')
@section('content')

 <ol class="breadcrumb page-breadcrumb">
	    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
	    <li class="breadcrumb-item">Stock</li>
	    <li class="breadcrumb-item active">Create</li>
	    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
	</ol>

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
	        <button style="float: right; margin-right: 10px; " class="btn btn-success ml-auto" id="addMore" type="submit">Add More</button>
	    </div>
    <div class="panel-container show">
        <div class="panel-content p-0">
            <form class="needs-validation" novalidate action="{{ route('stock.store') }}" method="post" id="stockForm">
            	@csrf
                <div class="panel-content">
                	<div id="parent-product">
                	
	                	<div class="single-product">
	                   		 <div class="form-row">
			                        <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom01">Brand <span class="text-danger">*</span></label>
			                            <select class="select2 custom-select" name="addmore[0][brand]" required="">
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
			                            <select class="select2 custom-select" name="addmore[0][type]" required="">
			                                <option value="">State Type</option>
			                                @foreach($types as $type)
			                                 <option value=" {{ $type->id }} ">{{ trim($type->types_name) }}</option>
			                                @endforeach
			                            </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid type.
			                            </div>
			                        </div>

			                         <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom">Size <span class="text-danger">*</span></label>
			                            <select class="select2 custom-select" name="addmore[0][size]" required="">
			                                <option value="">State Size</option>
			                                @foreach($sizes as $size)
			                                 <option value=" {{ $size->id }} ">{{ trim($size->name) }}</option>
			                                @endforeach
			                            </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid Size.
			                            </div>
			                        </div>

			                         

			                       <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom03">Per Packet quenty <span class="text-danger">*</span></label>
			                            <select class="select2 custom-select per_packet_quenty_0"    name="addmore[0][per_pkt_qty]" required="">
			                                <option value="">State Per Packet quenty</option>
			                                <option value="12">12</option>
			                                <option value="6">6</option>
			                               
			                            </select>
			                            <div class="invalid-feedback">
			                                Please provide a valid  Packet quenty.
			                            </div>
			                        </div>


			                        <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom03">Packet quenty <span class="text-danger">*</span></label>

			                             <input type="number" class="form-control"  name="addmore[0][pkt_qty]" id="validationCustom02" placeholder="Packet quenty"  required>
			                            <div class="invalid-feedback">
			                                Please provide a valid Per Packet quenty.
			                            </div>
			                        </div>
			                       

			                         


			                         <div class="col-md-4 mb-3">
			                           <label class="form-label" for="validationCustom03">Lot No <span class="text-danger">*</span></label>
			                             <input type="number" class="form-control" name="addmore[0][lot_no]" id="validationCustom02" placeholder="Stock Number" value="{{ $lot_no }}"  required readonly="">
			                            <div class="invalid-feedback">
			                                Please provide a valid Per Stock Number.
			                            </div>
			                        </div>

			                       

			                        

	                        </div> 
                	</div>{{-- end-single-product --}}

                	




{{-- <div class="content-div">
   <div class="form-row">
      <div class="col-md-11 mb-3">
         <hr>
      </div>
      <div class="col-md-1 mb-3"> <button type="button" class="btn btn-danger remove-div">Remove</button> </div>
   </div>
   </span> 
   <div class="single-product">
      <div class="form-row">
         <div class="col-md-4 mb-3">
            <label class="form-label" for="validationCustom01">Brand <span class="text-danger">*</span></label> 
            <select class="select2 custom-select" name="addmore['+i+'][brand]" required="">
               <option value="">State Brand</option>
               @foreach($brands as $brand) 
               <option value=" {{ $brand->id }} ">{{ $brand->name }}</option>
               @endforeach 
            </select>
            <div class="invalid-feedback">  Please provide a valid brand. </div>
         </div>

          <div class="col-md-4 mb-3">
            <label class="form-label" for="validationCustom"> Type <span class="text-danger">*</span></label>  
            <select class="select2 custom-select" name="addmore['+i+'][type]" required="">
               <option value="">State Type</option>
                @foreach($types as $type)
                 <option value=" {{ $type->id }} ">{{ $type->types_name }}</option>
                @endforeach 
            </select>
            <div class="invalid-feedback"> Please provide a valid type. </div>
         </div>



         <div class="col-md-4 mb-3">
            <label class="form-label" for="validationCustom">Size <span class="text-danger">*</span></label>  
            <select class="select2 custom-select" name="addmore['+i+'][size]" required="">
               <option value="">State Size</option>
               @foreach($sizes as $size)  
               <option value=" {{ $size->id }} ">{{ $size->name }}</option>
               @endforeach  
            </select>
            <div class="invalid-feedback"> Please provide a valid Size. </div>
         </div>

         

         <div class="col-md-4 mb-3">
            <label class="form-label" for="validationCustom03">Per Packet quenty <span class="text-danger">*</span></label> 
            <select class="select2 custom-select per_packet_quenty_'+i+'" name="addmore['+i+'][per_pkt_qty]" required="" onchange="per_Packet_qty('+i+')">
               <option value="">State Per Packet quenty</option>
               <option value="12">12</option>
               <option value="6">6</option>
            </select>
            <div class="invalid-feedback"> </div>
         </div>

         <div class="col-md-4 mb-3">
            <label class="form-label" for="validationCustom03">Packet quenty <span class="text-danger">*</span></label> <input type="number" class="form-control"  name="addmore['+i+'][pkt_qty]" id="validationCustom02" placeholder="Packet quenty"  required> 
            <div class="invalid-feedback">  Please provide a valid Per Packet quenty. </div>
         </div>
         
         
         <div class="col-md-4 mb-3">
            <label class="form-label" for="validationCustom03">Lot No <span class="text-danger">*</span></label> <input type="number" class="form-control" name="addmore['+i+'][lot_no]" id="validationCustom02" placeholder="Stock Number" value="{{ $lot_no }}"  required readonly=""> 
            <div class="invalid-feedback"> </div>
         </div>
        
         
      </div>
   </div>
</div>
 --}}






















                </div>

                <button class="btn btn-primary ml-auto" id="disableButton" type="submit">Submit form</button>
            </form>
            
        </div>
    </div>
</div>
</div>

@endsection

@push('js')
<script src="{{ asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script>

$(document).ready(function(){

	$('.select2').select2();

	

});
	 


</script>

<!-- add more script -- -->
<script>
	var i =0;
	$('#addMore').click(function(){

		++i;
		$('#parent-product').append('<div class="content-div"><div class="form-row"> <div class="col-md-11 mb-3"><hr></div> <div class="col-md-1 mb-3"> <button type="button" class="btn btn-danger remove-div">Remove</button> </div> </div> </span> <div class="single-product"> <div class="form-row"> <div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom01">Brand <span class="text-danger">*</span></label> <select class="select2 custom-select" name="addmore['+i+'][brand]" required=""> <option value="">State Brand</option> @foreach($brands as $brand)  <option value=" {{ $brand->id }} ">{{ trim($brand->name) }}</option> @endforeach   </select> <div class="invalid-feedback">  Please provide a valid brand. </div></div> <div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom"> Type <span class="text-danger">*</span></label>   <select class="select2 custom-select" name="addmore['+i+'][type]" required=""> <option value="">State Type</option> @foreach($types as $type)<option value=" {{ $type->id }} ">{{ trim($type->types_name) }}</option>  @endforeach  </select>  <div class="invalid-feedback"> Please provide a valid type. </div> </div> <div class="col-md-4 mb-3"> <label class="form-label" for="validationCustom">Size <span class="text-danger">*</span></label>   <select class="select2 custom-select" name="addmore['+i+'][size]" required=""> <option value="">State Size</option> @foreach($sizes as $size)  <option value=" {{ $size->id }} ">{{ trim($size->name) }}</option>  @endforeach   </select><div class="invalid-feedback"> Please provide a valid Size. </div> </div> <div class="col-md-4 mb-3"><label class="form-label" for="validationCustom03">Per Packet quenty <span class="text-danger">*</span></label>  <select class="select2 custom-select per_packet_quenty_'+i+'" name="addmore['+i+'][per_pkt_qty]" required="" > <option value="">State Per Packet quenty</option><option value="12">12</option> <option value="6">6</option> </select> <div class="invalid-feedback"> </div> </div> <div class="col-md-4 mb-3"><label class="form-label" for="validationCustom03">Packet quenty <span class="text-danger">*</span></label> <input type="number" class="form-control"  name="addmore['+i+'][pkt_qty]" id="validationCustom02" placeholder="Packet quenty"  required> <div class="invalid-feedback">  Please provide a valid Per Packet quenty. </div> </div><div class="col-md-4 mb-3"><label class="form-label" for="validationCustom03">Lot No <span class="text-danger">*</span></label> <input type="number" class="form-control" name="addmore['+i+'][lot_no]" id="validationCustom02" placeholder="Stock Number" value="{{ $lot_no }}"  required readonly="">  <div class="invalid-feedback"> </div>  </div></div></div></div>');

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
                                    if(data.status === 200){
                                        cuteAlert({
                                            type      : "success",
                                            title     : "Success",
                                            message   : "Product stock Added Sucessfully",
                                            buttonText: "ok"
                                        }).then((e)=>{
                                            location.reload(true);
                                        });
                                    }else if(data.status === 400){

                                        cuteAlert({
                                            type      : "warning",
                                            title     : "Warning",
                                            message   : "Sorry product type not match",
                                            buttonText: "ok"
                                        })


                                    }else{

                                        alert(data.message);                                        
                                    }

                                    console.log(data)

                                                         
                                },
                                error: function(data) {
                                    console.log(data);
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