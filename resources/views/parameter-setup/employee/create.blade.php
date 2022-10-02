@extends('layouts.app')
@section('title','Employee')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item">Parameter</li>
        <li class="breadcrumb-item active">Employee Setup Form</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-12 col-md-12 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>Employee Setup Form</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <form id="employee_form" action="{{ route('parameter_setup.employee.store') }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="row">
                                <div class="col-6">

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="employee_name"> Employee Name </label>
                                            <input type="text" placeholder="Employee Name" name="employee_name" class="form-control" id="employee_name" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="designation"> Designation </label>
                                            <select class="form-control select2" name="designation" id="designation" required>
                                                <option value="">Select Desination</option>
                                                @foreach($designations as $single_data)
                                                <option value="{{ $single_data->id }}">{{ $single_data->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="father_name"> Fathter Name </label>
                                            <input type="text" placeholder="Fathter Name" name="father_name" class="form-control" id="father_name" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="mother_name"> Mother Name </label>
                                            <input type="text" placeholder="Mother Name" name="mother_name" class="form-control" id="mother_name" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="spouse_name"> Spouse Name </label>
                                            <input type="text" placeholder="Spouse Name" name="spouse_name" class="form-control" id="spouse_name" >
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="nominee_name"> Nominee Name </label>
                                            <input type="text" placeholder="Nominee Name" name="nominee_name" class="form-control" id="nominee_name" >
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="mobile_no"> Mobile No </label>
                                            <input type="text" placeholder="Mobile Name" name="mobile_no" class="form-control" id="mobile_no" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-6">

                                    
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="nid_no"> NID </label>
                                            <input type="text" placeholder="NID No" name="nid_no" class="form-control" id="nid_no" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="account_no"> Account No </label>
                                            <input type="text" placeholder="Account  No" name="account_no" class="form-control" id="account_no" >
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="present_add">Present Address </label>
                                            <input type="text" placeholder="Present Address" name="present_add" class="form-control" id="present_add" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="parmanent_add">Parmanent Address </label>
                                            <input type="text" placeholder="Parmanent Address" name="parmanent_add" class="form-control" id="parmanent_add" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="join_date">Join Date </label>
                                            <input type="date" placeholder="Join Date" name="join_date" class="form-control" id="join_date" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="employee_img"> Image </label>
                                            <input type="file" placeholder="Join Date" name="employee_img" class="form-control" id="employee_img">
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>

                                </div>


                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary  waves-effect waves-themed submit_btn" type="submit">Submit form</button>
                                </div>

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



<script>
    $(function() {
        var $form = $(this);
        $.validator.setDefaults({
            errorClass: 'help-block'
            , highlight: function(element) {
                $(element)
                    .closest('.form-group')
                    .addClass('has-error');
            }
            , unhighlight: function(element) {
                $(element)
                    .closest('.form-group')
                    .removeClass('has-error');
            }
        });



        $("#employee_form").validate({
            rules: {
                employee_name: { required: true }, 
                designation: { required: true } , 
                father_name: { required: true },
                mother_name: {required: true },
                mobile_no: {required: true },
                nid_no: {required: true },
                account_no: {required: true },
                present_add: {required: true },
                parmanent_add: {required: true },
                join_date: {required: true },

            }
            , submitHandler: function(form) {
                var formdata = new FormData(this);
               
            
                cuteAlert({
                    type: "question"
                    , title: "Confirmation"
                    , message: "Are your sure ? Add this Client"
                    , confirmText: "Yes"
                    , cancelText: "No"
                }).then((e) => {
                    if (e == ("confirm")) {
                        $.ajax({
                             url: '{{ route('parameter_setup.employee.store') }}',
                             type: 'POST',
                             data: {formdata, "_token": "{{ csrf_token() }}"},
                             beforeSend: function() {
                                loaderStart();
                            }
                            , success: (data) => {
                                if (data.status == 200) {
                                    cuteAlert({
                                        type: "success"
                                        , title: "Success"
                                        , message: data.message
                                        , buttonText: "ok"
                                    }).then((e) => {
                                        //location.reload(true);
                                        window.location.href = "{{ route('parameter_setup.employee.index') }}";
                                    });
                                } else if (data.status == 400) {

                                    cuteAlert({
                                        type: "warning"
                                        , title: "Warning"
                                        , message: data.message
                                        , buttonText: "ok"
                                    })


                                } else {

                                    alert(data.message);
                                }

                            console.log(data);

                            }
                            , error: function(data) {

                            }
                            , complete: function() {
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
