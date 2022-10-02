@extends('layouts.app')
@section('title','Rack-Fillup')

@push('css')

 

<link rel="stylesheet" href="{{ asset('public/backend/assets/css/datagrid/datatables/datatables.bundle.css') }}">

<style>
    .custom-count{
        color: white !important;
        background-color: #fd3995;
        padding: 4px 12px 4px;
        border-radius: 41px;
    }
</style>

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Rack Socks</li>
            <li class="breadcrumb-item active"> Rack Socks Return </li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-8 col-md-8 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Rack Socks Return</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <form id="socks_return_from_rack" action="{{ route('rack.socks_return.find_socks') }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Rack Code</label>
                                        <select class="form-control select2" name="rack_code" id="rack_code" required>
                                            <option value="">Select Rack</option>
                                            @foreach($racks as $rack)
                                                <option value="{{ $rack->rack_code }}"> {{ $rack->rack_code }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">

                                        <label for="total_select_socks" class="form-label" for="name">Total Selected Socks : </label>
                                         <span id="total_select_socks" class="text-danger custom-count  font-weight-bold h4 m-4">0</span>
                                    </div>
                                </div>  
                                <div id="socks_list">
                                    
                                </div>                               
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="button" id="SubmitBtn">Socks Return</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="find_socks_list" value="{{ route('rack.socks_return.find_socks_list') }}">
        <input type="hidden" id="delete_socks_route" value="{{ route('rack.socks_return.delete_socks') }}">
    </main>
@endsection

@push('js')
<script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/datagrid/datatables/datatables.export.js') }}"></script>

<script>
    $("#rack_code").on('change', function(){
        var rack_code       = $("#rack_code").val();
        var find_socks_list = $("#find_socks_list").val();
        var _token          = $("#_token").val();
        if(rack_code != ''){
            $.ajax({
                type: 'POST',
                url : find_socks_list,
                data: {
                    "_token"   : _token,
                    "rack_code": rack_code,
                },
                beforeSend: function() {
                    loaderStart();
                },
                success: (data) => {
                    //$("#socks_code").empty().append(data);
                    $('#socks_list').html(data);
                    getDatatable();
                },
                error: function(data) {
                    
                },
                complete: function() {
                    loaderEnd();
                }
            });
        } 
    });
</script>

{{-- <script>
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




            $("#socks_return_from_rack").validate({
                rules: {
                    rack_code: {
                        required: true
                    },
                    socks_code: {
                        required: true
                    }
                },


                submitHandler: function(form) {
                    var delete_socks_route = $('#delete_socks_route').val();
                    var rack_code = $('#rack_code').val();
                    var socks_code=[];
                    $(':checkbox:checked').each(function(i))
                    {
                        socks_code[i] = $(this).val();
                    }
                    
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? You want to return socks from rack",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: delete_socks_route,
                                //data: $(form).serialize(),
                                data: {
                                    'rack_code' : rack_code,
                                    'socks_code' : socks_code,
                                    "_token": "{{ csrf_token() }}"
                                }
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
                                           location.reload(true);
                                        });
                                    }else{
                                        cuteAlert({
											type: "error",
											title: "Error",
											message: data.message,
											buttonText: "Try Again"
										});                                 
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
</script> --}}


<script>

function single_checkbox()
{
    var socks_code=[];
    $(':checkbox:checked').each(function(i){
        //batch = $(this).val();
        socks_code[i] = $(this).val();
    });

    $('#total_select_socks').html(socks_code.length);
}

$('#SubmitBtn').click(function(){
         
    var delete_socks_route = $('#delete_socks_route').val();
    var rack_code = $('#rack_code').val();
    var socks_code=[];
    $(':checkbox:checked').each(function(i){
        //batch = $(this).val();
        socks_code[i] = $(this).val();
    });

    if(socks_code !='')
    {

        cuteAlert({
            type       : "question",
            title      : "Confirmation",
            message    : "Are your sure ?"+socks_code.length +" Socks You want to return socks from rack ",
            confirmText: "Yes",
            cancelText : "No"
        }).then((e)=>{
            if (e == ("confirm")){
                $.ajax({
                    type: 'POST',
                    url: delete_socks_route,
                    data: { rack_code : rack_code, socks_code: socks_code,  "_token": "{{ csrf_token() }}" },
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
        

    }else{
      
        cuteAlert({
            type      : "error",
            title     : "Error",
            message   : "Socks Code not select",
            buttonText: "ok"
        })
    }

  


    
 
       
         
         
});
</script>


<script>
    /*data table script*/



    

    $(document).ready(function()
           {
               getDatatable();
              
           });

   /*data table script*/


   function getDatatable()
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
                       }
                       
                       
                   ],
                   "lengthMenu": [
                       [1000, 2000, 300, -1]
                   ]
               });

    }
</script>


@endpush
