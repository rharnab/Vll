@extends('layouts.app')
@section('title','Bill Collection')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Month Wise Bill Collection</li>
            <li class="breadcrumb-item active">Month wise</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2> <span class="text-info text-uppercase">{{ $shops_info->name }} [ {{ $shops_info->rack_code }} ]  &nbsp; </span> Bill Collection  Form </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="commission_form"  method="post" enctype="multipart/form-data">

                            	@csrf

                            	<input type="hidden" name="shop_id" id="shop_id" value="{{ Crypt::encrypt($shops_info->shop_id) }} " >

                            	<input type="hidden" name="rack_code" id="rack_code" value="{{ Crypt::encrypt($shops_info->rack_code) }} " >

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Select Month </label>
                                        
                                        <select class="form-control select2" name="due_month" id="due_month" required>
                                           
                                        	@if(!empty($payable_month_due))
                                           <option value="{{ $payable_month_due->sale_date }}"> {{ date('M Y', strtotime($payable_month_due->sale_date)) }}</option>
                                           @endif

                                           @if(count($all_due) > 0)
                                           @foreach($all_due as $single_due)

                                           <option  disabled value=""> {{ date('M Y', strtotime($single_due->sale_date)) }}</option>

                                           @endforeach

                                           @endif

                                           
                                            
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                <div class="form-row">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Due Amount </label>

                                        	@if(!empty($payable_month_due))
                                           <input readonly type="text"   name="pay_amount"  class="form-control" value="{{ $payable_month_due->due_blill }}"  maxlength="10" >

                                           @endif
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>

                                <div class="form-row">

                                	<div class="col-md-12 mb-3">

                                		<div class="frame-wrap">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                   <input type="checkbox" name="chk_full" class="custom-control-input" id="chk_full" checked>
                                                    <label class="custom-control-label" for="chk_full">Full Amount</label>
                                                </div>
                                                <div class="custom-control custom-checkbox custom-control-inline" style="display: none">
                                                    <input type="checkbox" name="chk_other" class="custom-control-input" id="chk_other" >
                                                    <label class="custom-control-label" for="chk_other">Other Amount</label>
                                                </div>
                                               
                                            </div>
                                	</div>
                                      
                                </div>

                                <div class="form-row pay_amount_area" style="display: none;">
                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Amount </label>
                                           <input type="text" onblur="checkAmount()" placeholder="Other Amount" name="pay_amount"  class="form-control" id="pay_amount" maxlength="10" >
                                        <div class="valid-feedback"></div>

                                    </div>
                                </div>


                                
                               
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">Submit form</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>


    <!-- <input type="hidden" valule="{{ route('parameter_setup.commission.store') }}" id="parameter_setup_commission_store"> -->
 
@endsection

@push('js')

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

        

            $("#commission_form").validate({
                rules: {
                    due_month: { required: true},
                    shop_id: { required: true},
                    rack_code: { required: true},
                   
                },
                submitHandler: function(form) {

                	var base_url = window.location.origin + '/';
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? Want to Pay this Bill",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('bill.collection.single_month_due') }}',
                                data: $(form).serialize(),
                                beforeSend: function() {
                                    loaderStart();
                                },
                                success: (data) => {

                                   if(data.status === 200){
                                    cuteAlert({
                                        type      : "success",
                                        title     : "Success",
                                        message   : data.message,
                                        buttonText: "ok"
                                    }).then((e)=>{
                                        $("#bill_collection_btn").prop('disabled', true);
                                       
                                        window.location = base_url+"voucher/shop/rack-bill-info/"+data.bill_no;
                                       
                                    });
                                }else{
                                    cuteAlert({
                                        type: "error",
                                        title: "Error",
                                        message: data.message,
                                        buttonText: "Try Again"
                                    });                                 
                                }


                                    console.log(data);

                                  

                                                         
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


<script type="text/javascript">
	$('#chk_full').click(function(){

		$('.pay_amount_area').hide();
		$('#pay_amount').attr('required', false);

		if($('#chk_other').is(':checked'))
		{
			$('#chk_other').prop('checked', false);
		}else{
			$('#chk_full').prop('checked', true);
			
			
		}
		

	});

	$('#chk_other').click(function(){

		$('.pay_amount_area').show();
		$('#pay_amount').attr('required', true);

		if($('#chk_full').is(':checked'))
		{
			$('#chk_full').prop('checked', false);
			
		}else{
			$('#chk_other').prop('checked', true);
			

		}
		

	});
</script>

<script type="text/javascript">
	

	function checkAmount()
	{

		var pay_amount = $('#pay_amount').val();
		var due_month = $('#due_month').val();
		var shop_id = $('#shop_id').val();

		if(pay_amount !='')
		{
			$.ajax({

				type : "post",
				url : "{{ route('bill.collection.check_bill') }}",
				data : {
					'due_month' : due_month,
					'pay_amount': pay_amount,
					'shop_id'  : shop_id,
					'_token'  : '{{ @csrf_token() }}',

				},

                success: function(result)
                {
                	due_amount  = parseFloat(result);
                	
                	if(pay_amount <=  due_amount)
                	{
                		return true;
                	}else{
                		
                		 cuteAlert({
                            type      : "warning",
                            title     : "Warning",
                            message   : "Please Check Due Amount",
                            buttonText: "ok"
                        });
                	}

                }
               
			})
		}

	}
</script>
    
@endpush
