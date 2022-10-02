@extends('layouts.app')
@section('title','finace bill collection')



@section('content')

	<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Finance Rack Bill Collection</li>
            
        </ol>



        <div class="row">
            <div class="col-xl-6 col-md-6 col-sm-6">

            	

                <!-- data table -->
                 <div id="panel-1" class="panel">
                        <div class="panel-hdr">

                        	

                            <h2>
                              Search Socks Bill No
                            </h2>

                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                            </div>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
                                
                                <form id="" action="{{ route('finance.rack.bill-collection.search_result') }}" method="get" enctype="multipart/form-data">

                                @csrf


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Socks Bill No</label>
                                        	
                                        	<input type="text" name="shocks_bill_no" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                                                            
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed search_btn" type="submit">Search</button>
                                </div>
                            </form>
                            
                            </div>
                        </div>
                    </div>

                <!-- data table -->
            </div>

            

             @if(!empty($get_data))
             <div class="col-xl-6 col-md-6 col-sm-6">

             	 <div id="panel-1" class="panel">

             	 	<div class="panel-hdr">
                            <h2>
                               Socks Bill Info Table
                            </h2>

                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                            </div>
                        </div>


                       
                        <div class="panel-container show">
                            <div class="panel-content">

                            	<table class="table table-bordered table-hover table-striped table-sm w-100">

                            		<tr>
                            			<th>Shocks Bill No</th>
                            			<td>
                            			<?php 

                            			if (!empty($get_data[0]->shocks_bill_no)) {
                            				echo $shocks_bill_no = $get_data[0]->shocks_bill_no;
                            			}else{
                            				echo $shocks_bill_no ="";
                            			}
                            			


                            			?></td>
                            		</tr>

                            		<tr>
                            			<th>Agent Name</th>
                            			<td>
                            			<?php 

                            			if (!empty($get_data[0]->agent_name)) {
                            				echo $agent_name = $get_data[0]->agent_name;
                            			}else{
                            				echo $agent_name ="";
                            			}
                            			


                            			?></td>
                            		</tr>

                            		<tr>
                            			<th>Shop Name</th>
                            			<td>
                            			<?php 

                            			if (!empty($get_data[0]->shop_name)) {
                            				echo $shop_name = $get_data[0]->shop_name;
                            			}else{
                            				echo $shop_name ="";
                            			}
                            			


                            			?></td>
                            		</tr>

                            		

                            		<tr>
                            			<th>Voucher Link</th>
                            			<td>
                            				
                            				<?php 

                            			if (!empty($get_data[0]->voucher_link)) {
                            				  $voucher_link = $get_data[0]->voucher_link;
                            				?>

                            				<a href="{{url($voucher_link)}}" download>Download</a>
                            				<?php 
                            			}else{
                            				echo $voucher_link ="";
                            			}
                            			


                            			?>


                            			</td>
                            		</tr>


                            		<tr>
                            			<th>Rack Code</th>
                            			<td>
                            				
	                            			<?php 

	                            			if (!empty($get_data[0]->rack_code)) {
	                            				echo $rack_code = $get_data[0]->rack_code;
	                            			}else{
	                            				echo $rack_code ="";
	                            			}
	                            			


	                            			?>

                            			</td>
                            		</tr>

                            		<tr>
                            			<th>Quantity</th>
                            			<td>
                            				<?php 

	                            			if (!empty($get_data[0]->quantity)) {
	                            				echo $quantity = $get_data[0]->quantity;
	                            			}else{
	                            				echo $quantity ="";
	                            			}
	                            			


	                            			?>

                            			</td>
                            		</tr>


                            		<tr>
                            			<th>Total Amount</th>
                            			<td>
                            				<?php 

	                            			if (!empty($get_data[0]->total_amount)) {

	                            				echo $total_amount = $get_data[0]->total_amount;

	                            			}else{
	                            				echo $total_amount ="";
	                            			}
	                            			


	                            			?>
                            			</td>
                            		</tr>

                            		<tr>
                            			<th>Shop Commission Percentage</th>
                            			<td>
                            				<?php 

	                            			if (!empty($get_data[0]->shop_commission_percentage)) {

	                            				echo $shop_commission_percentage = $get_data[0]->shop_commission_percentage;
	                            				
	                            			}else{
	                            				echo $shop_commission_percentage ="";
	                            			}
	                            			


	                            			?>

                            			</td>
                            		</tr>


                            		<tr>
                            			<th>Shop Commission Amount</th>
                            			<td>
                            				
                            				<?php 

	                            			if (!empty($get_data[0]->shop_commission_amount)) {

	                            				echo $shop_commission_amount = $get_data[0]->shop_commission_amount;
	                            				
	                            			}else{
	                            				echo $shop_commission_amount ="";
	                            			}
	                            			


	                            			?>

                            			</td>
                            		</tr>



                            		<tr>
                            			<th>Agent Commission Percentage</th>
                            			<td>
                            				<?php 

	                            			if (!empty($get_data[0]->agent_commission_percentage)) {

	                            				echo $agent_commission_percentage = $get_data[0]->agent_commission_percentage;
	                            				
	                            			}else{
	                            				echo $agent_commission_percentage ="";
	                            			}
	                            			


	                            			?>

                            			</td>
                            		</tr>

                            		<tr>
                            			<th>Venture Amount</th>
                            			<td>
                            				<?php 

	                            			if (!empty($get_data[0]->venture_amount)) {

	                            				echo $venture_amount = $get_data[0]->venture_amount;
	                            				
	                            			}else{
	                            				echo $venture_amount ="";
	                            			}
	                            			


	                            			?>

                            			</td>
                            		</tr>
                            		<br>

                            		<tr>
                            			<td colspan="2">
                            				<button class="btn btn-primary " type="button" style="float: right;" onclick="approved_amount('{{$shocks_bill_no}}');">Approved Amount</button>
                            			</td>
                            		</tr>
                            	</table>


                            </div>

                        </div>

                      

             	 </div>

             </div>	


 				

                        	

              @endif



        </div>


        







    </main>
	
	  <input type="hidden" id="_token" value="{{ csrf_token() }}">

@endsection




@push('js')

<script type="text/javascript">
	function approved_amount(socks_bill_no){

		 var _token    = $("#_token").val();
		// alert(socks_bill_no);

		cuteAlert({
		  type: "question",
		  title: "Do You Want To Apporoved ",
		  message: "",
		  confirmText: "Okay",
		  cancelText: "Cancel"
		}).then((e)=>{

		 	$.ajax({
                    type: 'POST',
                    url : "{{url('finance/rack/bill-collection/approved-amount')}}",
                    data: {
                        "_token"     : _token,
                        "socks_bill_no"    : socks_bill_no,
                       
                    },
                    beforeSend: function() {
                        loaderStart();
                    },
                    success: (data) => {
                      

                        if (data==1) {
                        	cuteToast({
								  type: "success", // or 'info', 'error', 'warning'
								  message: "Data Insert successful",
								  timer: 5000
								})

							window.location.href = "{{url('finance/rack/bill-collection/search')}}";

                        }else{

                        	cuteAlert({
							  type: "error",
							  title: "Error Title",
							  message: "Error Message",
							  buttonText: "Okay"
							})

							
                        }
                    },
                    error: function(data) {
                       
                    },
                    complete: function() {
                        loaderEnd();
                    }
                });

		})

	}
</script>

@endpush


