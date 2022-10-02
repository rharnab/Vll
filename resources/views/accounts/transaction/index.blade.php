@extends('layouts.app')
@section('title','Transaction')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Account </li>
            <li class="breadcrumb-item active"> Transaction Auth List </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                     <h2>Transaction Auth List   </h2>
                                     <p><button  type="button" class="btn btn-primary mt-2 mr-4 authBtn">Authorize</button></p>
                                     <p><button  type="button" class="btn btn-danger mt-2 mr-4 decline">Decline</button></p>

                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            
                                            <!-- datatable start -->
                                            <table class="table table-bordered table-hover m-0" id="dt-basic-example">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>No 
                                                            <input type="checkbox" id="checkAll" >
                                                        </th>
                                                        <th>From Account </th>
                                                        <th>To Account </th>
                                                        <th>From Account Number</th>
                                                        <th>To Account Number</th>
                                        
                                                        <th>Amount </th>
                                                        <th>Payee </th>
                                                        <th>Remarks </th>
                                                        <th>transaction Date</th>
                                                        <th>Status</th>
                                                        
                                                       
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                	@endphp
                                                    
                                                	@foreach($data as $single_data)
                                                    
                                                    @php

                                                    $cr_info= explode('-', $single_data->cr_transaction_info); 

                                                    @endphp

                                                	<tr>

                                                		<td>
                                                        <input type="checkbox"  value="{{ $single_data->batch_no}}" name="batch_no[]"> 
                                                            {{ $sl++ }}</td>
                                                		<td>{{ $single_data->dr_ac }}</td>
                                                        
                                                        <td>{{ $cr_info[1] }} </td>

                                                        <td>{{ $single_data->dr_acc }}</td>

                                                        <td>{{ $cr_info[0] }} </td>
                                                        <td>{{ str_replace('-','', $single_data->dr_amount) }}</td>
                                                        <td>{{ $single_data->name }}</td>
                                                        <td>{{ $single_data->remarks}}</td>
                                                        <td>{{ $single_data->dr_trn_date}}</td>
                                                        

                                                        <td>
                                                            @if( $single_data->dr_status == 0)
                                                        Pedding
                                                        @else
                                                        authorize
                                                        @endif
                                                    
                                                    </td>
                                                			

                                                			

                                                	</tr>

                                                     

                                                

                                                	@endforeach
                                                	
                                                	                                                   
                                                </tbody>
                                            </table>
                                            <!-- datatable end -->

                                           
                                        </div>
                                    </div>
                                </div>

                <!-- data table -->
            </div>

        </div>


        




    </main>
@endsection

@push('js')

 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
 <script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>

 <script>
     
     $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
 </script>

 <script>
    $(function(){
      $('#checkAll').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
          
        });

      });
    });
 </script>

 <script>
     $('.authBtn').click(function(){
         
        var batch_no = [];
        $(':checkbox:checked').each(function(i){
            //batch = $(this).val();
            batch_no[i] = $(this).val();
        });
      
        cuteAlert({
            type       : "question",
            title      : "Confirmation",
            message    : "Are your sure ? Create this transaction ",
            confirmText: "Yes",
            cancelText : "No"
        }).then((e)=>{
            if (e == ("confirm")){
                $.ajax({
                    type: 'POST',
                    url: '{{ route('account.transaction.auth_process') }}',
                    data: { batch_no : batch_no,  "_token": "{{ csrf_token() }}" },
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

                            
                        }else if(data.status==400)
                        {
                            cuteAlert({
                                type      : "warning",
                                title     : "Warning",
                                message   : data.message,
                                buttonText: "ok"
                            });
                        }else{
                            alert(data.message);                                        
                        }

                        console.log(data);
                        
                                                
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    complete: function() {
                        loaderEnd();
                    }
                    
                    
                });
                
            }

        });

        
     })
 </script>


<!-- decline button -->
<script>
     $('.decline').click(function(){
         
        var batch_no = [];
        $(':checkbox:checked').each(function(i){
            //batch = $(this).val();
            batch_no[i] = $(this).val();
        });
      
        cuteAlert({
            type       : "question",
            title      : "Confirmation",
            message    : "Are your sure ? Decline this transaction ",
            confirmText: "Yes",
            cancelText : "No"
        }).then((e)=>{
            if (e == ("confirm")){
                $.ajax({
                    type: 'POST',
                    url: '{{ route('account.transaction.decline') }}',
                    data: { batch_no : batch_no,  "_token": "{{ csrf_token() }}" },
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

                            
                        }else if(data.status==400)
                        {
                            cuteAlert({
                                type      : "warning",
                                title     : "Warning",
                                message   : data.message,
                                buttonText: "ok"
                            });
                        }else{
                            alert(data.message);                                        
                        }

                        console.log(data);
                        
                                                
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    complete: function() {
                        loaderEnd();
                    }
                    
                    
                });
                
            }

        });

        
     })
 </script>

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
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'copyHtml5',
                            text: 'Copy',
                            titleAttr: 'Copy to clipboard',
                            className: 'btn-outline-primary btn-sm mr-1'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm'
                        }
                    ]
                });

            });
    </script>




@endpush