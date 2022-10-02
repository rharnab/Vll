@extends('layouts.app')
@section('title','Salary Disburse')

@push('css')


<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Salary Disburse</li>
            <li class="breadcrumb-item active">Disbursement Salary Pending List</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

<div class="subheader">
        
    </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">

              
                <!-- data table -->
                 <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                     <h2>Authorization Pending Salary List</h2>
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
                                            <table class="table table-bordered table-hover m-0 text-center" style="width:100%; overflow-x: scroll;" id="dt-basic-example">
                                                <thead class="bg-primary-600">
                                                    <tr>
                                                        <th>
                                                            <label for="checkAll">#No</label>
                                                            <input  type="checkbox" id="checkAll" value="">
                                                        </th>
                                                        <th>Employee Name</th>
                                                        <th>Month</th>
                                                        <th>Monthly Salary</th>
                                                        <th>Paid Salary </th>                                                        
                                                        <th>Due Salary</th>
                                                        <th>Remarks</th>
                                                        <th>Option</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                	@php
                                                	$sl=1;
                                                    @endphp
                                                    @foreach($pendig_data as  $single_data)
                                                    @php
                                                        $date_array = explode('-', $single_data->salary_month_year);
                                                        $date = $date_array['0']."/01/".$date_array['1'];
                                                        $salary_month = date('M-Y', strtotime($date));

                                                        $due_salary = $single_data->due_salary_amount -  $single_data->disburse_amount;
                                                    @endphp
                                                        
                                                  <tr>
                                                      <td>
                                                          <label for=""> {{ $sl++ }}</label>
                                                          <input type="checkbox" value="{{ $single_data->id  }}" name="batch_no[]"> 
                                                       </td>
                                                      <td>{{ $single_data->name }}</td>
                                                      <td>{{ $salary_month }}</td>
                                                      <td>{{ $single_data->due_salary_amount }}</td>
                                                      <td>{{ $single_data->disburse_amount }}</td>
                                                      <td>{{ ($due_salary > 0)? $due_salary : '-' }}</td>
                                                      <td>{{ $single_data->remarks }}</td>
                                                      <th><a class="btn btn-sm btn-primary" href="{{ route('salary.disburse.amendment', Crypt::encrypt($single_data->id)) }}">Amendement</a></th>
                                                  </tr>
                                                	@endforeach
                                                	
                                                	                                                   
                                                </tbody>
                                            </table>
                                            <!-- datatable end -->

                                           
                                        </div>
                                    </div>
                                </div>

                <!-- data table -->

                {{------------------------- start modal -------------------------------}}
                <!-- Button trigger modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="remakrsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Decline Remarks</h5>
                            
                            </div>
                            <div class="modal-body">

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="remarks"> Remarks </label>
                                    <input type="text" placeholder="Remarks" name="remarks" id="remarks" class="form-control" id="remarks" required>
                                    <div class="valid-feedback"></div>
                                </div>


                            </div>
                            <div class="modal-footer">
                           
                            <button type="button" class="btn btn-danger confirm_decline">Confirm Decline</button>
                            </div>
                        </div>
                        </div>
                    </div>
                {{------------------------- start modal -------------------------------}}




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
     $('.authBtn').click(function(){
         
        var batch_no = [];
        $(':checkbox:checked').each(function(i){

            batch_no[i] =$(this).val(); 
        });
        

        cuteAlert({
            type       : "question",
            title      : "Confirmation",
            message    : "Are your sure ? Disburse This Salary",
            confirmText: "Yes",
            cancelText : "No"
        }).then((e)=>{
            if (e == ("confirm")){
                $.ajax({
                    type: 'POST',
                    url: '{{ route('salary.disburse.authorize') }}',
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
                        }else if(data.status==400){
                            cuteAlert({
                                type      : "warning",
                                title     : "Warning",
                                message   : data.message,
                                buttonText: "ok"
                            });
                        }else{
                            alert(data.message);   
                            location.reload(true);                                     
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
                
            }

        });

        
     })
 </script>


<!-- decline button -->
<script>
    //remakrs show for decline
    $('.decline').click(function(){

        $('#remakrsModal').modal('show');
        var remarks = $('#remarks').val();
    });

    //confirm decline function
     $('.confirm_decline').click(function(){
        var batch_no = [];
        $(':checkbox:checked').each(function(i){
            batch_no[i] = $(this).val();
        });

      
        var remarks = $('#remarks').val();

        if(remarks !=''){

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
                        url: '{{ route('salary.disburse.decline') }}',
                        data: { batch_no : batch_no, remarks: remarks,   "_token": "{{ csrf_token() }}" },
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

                                
                            }else if(data.status==400){
                                cuteAlert({
                                    type      : "warning",
                                    title     : "Warning",
                                    message   : data.message,
                                    buttonText: "ok"
                                });
                            }else{
                                alert(data.message);                                        
                            }

                                                    
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

        }else{
            cuteAlert({
                type      : "warning",
                title     : "Warning",
                message   : "Please give reason for decline",
                buttonText: "ok"
            });
                   
        }
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
                    "scrollX": true,
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