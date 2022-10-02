@extends('layouts.app')
@section('title','Marketing Lead')

@push('css')
<link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item">Marketing Lead</li>
        <li class="breadcrumb-item active">Lead Create</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-8 col-md-8 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>Lead Register form</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                            data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                            data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                            data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">


                        <form id="lead_form" action="{{ route('parameter_setup.company.update') }}" method="post"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="officer_name"> Officer Name </label>
                                    <input type="text" readonly placeholder="Officer Name"
                                        value="{{ Auth::user()->name }}" name="officer_name" class="form-control"
                                        id="officer_name" required>
                                    <div class="valid-feedback"></div>
                                </div>
                            </div>



                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label " for="work_area"> Working Area </label>
                                    <select name="work_area" id="work_area" class="form-control select2" required>
                                        <option value="">--Select Area--</option>
                                        @foreach($works_area as $data)
                                        <option value="{{ $data->id }}">{{ $data->area_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label " for="work_type"> Work Type </label>
                                    <select  id="work_type"  name="work_type" class="form-control select2"
                                        onchange="getTypeForm(this.value)" required>
                                        <option value="">--Select Type--</option>
                                        @foreach($works_type as $data)
                                        <option value="{{ $data->id }}">{{ $data->work_name }}</option>
                                        @endforeach

                                    </select>

                                    <div class="valid-feedback">
                                    </div>
                                </div>
                            </div>

                            <div class="show-html-view"></div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="lead_date"> Lead Date </label>
                                    <input type="text"  name="lead_date" required  placeholder="mm/dd/yyyy" class="form-control" id="lead_date"
                                        required>
                                    <div class="valid-feedback"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="owner_name"> Remarks </label>
                                    <input type="text" placeholder="Remarks" required name="remarks" class="form-control"
                                        id="remarks" required>
                                    <div class="valid-feedback"></div>
                                </div>
                            </div>

                            <div
                                class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                <button class="btn btn-primary  waves-effect waves-themed submit_btn"
                                    type="submit">Submit
                                </button>
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
<script src="{{ asset('public/backend/assets/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

<script type="text/javascript">
    $('#lead_date').datepicker({
         format:'mm/dd/yyyy',
         startDate: '-1d',
         endDate:'+0d',
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

        

            $("#lead_form").validate({
                rules: {
                    officer_name: { required: true},
                    area: { required: true},
                    work_type: { required: true},
                    lead_date: { required: true},
                    remarks: { required: true},
                    
                },
                submitHandler: function(form) {
                   
                    cuteAlert({
                        type       : "question",
                        title      : "Confirmation",
                        message    : "Are your sure ? Add this Lead",
                        confirmText: "Yes",
                        cancelText : "No"
                    }).then((e)=>{
                        if (e == ("confirm")){
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('lead.store') }}',
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
                                            location.reload(true);
                                        });
                                    }else if(data.status == 400){

                                        cuteAlert({
                                            type      : "warning",
                                            title     : "Warning",
                                            message   : data.message,
                                            buttonText: "ok"
                                        })


                                    }else{

                                        alert(data.message);                                        
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


<script>
    function getTypeForm(id){
    if(id !=''){
        $.ajax({
            type:'post',
            url:'{{ route("lead.getHtmlForm") }}',
            data:{id: id, "_token": "{{ @csrf_token() }}"},
            beforeSend: function(){
                loaderStart();
            },
            success:function(data)
            {
                $('.show-html-view').empty().html(data);
                $('.select2').select2();
                //console.log(data);
            },
            complete:function(){
                loaderEnd();
            }
        });
    }
}
</script>


<script type="text/javascript">
    function findAllDue()
    {
        var rack_code = $('#rack_code').val();


       if(rack_code !='')
       {
            $.ajax({

                type : "post",
                url : "{{ route('bill.collection.all_due') }}",
                data : {
                   
                   
                    'rack_code'  : rack_code,
                    '_token'  : '{{ @csrf_token() }}',

                },
                dataType: 'json',
                cache: false,

                success: function(data)
                {
                    
                    $('#due_amount').val(data.total_due);
                    $('#shop_id').val(data.shop_id);
                    paymentAmount();

                }
               
            })
       }
    }
 
</script>


<script>
    function paymentAmount()
    {
        var full_amount  = $('#due_amount').val();

        if($('#full').is(':checked')){
            $('#full_amount').val(full_amount);
        }else{
            $('#full').prop('checked', false);
            $('#full_amount').val('');
        }

        if($('#partial').is(':checked')){
            $('#partial_amount').removeAttr('readonly', false);
            $('#partial_amount_area').show();
            $('#full_amount_area').hide();
        }else{
            $('#partial').prop('checked', false);
            $('#partial_amount').val('');
            $('#partial_amount').attr('readonly', true);
            $('#partial_amount_area').hide();
            $('#full_amount_area').show();
        }
    }
</script>

@endpush