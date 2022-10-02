@extends('layouts.app')
@section('title','Salary | Disburse')

@push('css')

<link rel="stylesheet" media="screen, print"
    href="{{ asset('public/backend/assets/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item active">Salary Disburse</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-6 col-md-6 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>Salary Set up Form</h2>
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

                        <form id="transaction_create_from" action="{{ route('salary.disburse.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="col-md-12 mb-3 select_2_error">
                                        <label class="form-label" for="employee_id"> Select Eployee</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id" required>

                                            <option value="">Select Employee</option>
                                            @foreach($all_employee as $single_data)
                                            <option value="{{ $single_data->id }}"> {{ $single_data->name }} </option>
                                            @endforeach

                                        </select>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="present_salary">Present Salary </label>
                                        <input type="text" placeholder="present Salary"  name="present_salary" id="present_salary"
                                            class="form-control" onblur="checkIncrementSalary()"  required>
                                        <div class="valid-feedback"></div>
                                        <small id="present_salary_in_word" style="color: red; font-weight:bold; text-transform:capitalize"></small>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="increment_salary">Increement Salary </label>
                                        <input type="text" placeholder="Amount" name="increment_salary" id="increment_salary"
                                            class="form-control" onblur="checkIncrementSalary()"  required>
                                        <div class="valid-feedback"></div>
                                        <small id="increment_salary_in_word" style="color: red; font-weight:bold; text-transform:capitalize"></small>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="effective_date"> Effective Date </label>
                                        <input type="date" name="effective_date" class="form-control" id="effective_date" required>
                                        <div class="valid-feedback"></div>

                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="remarks"> Remarks </label>
                                        <input type="text" placeholder="Remarks" name="remarks" id="remarks" class="form-control" id="remarks" required>
                                        <div class="valid-feedback"></div>

                                    </div>

                                </div>

                            </div>

                            <div
                                class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center p-2">
                                <button class="btn btn-primary  waves-effect waves-themed submit_btn"
                                    type="submit">Submit form</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<input type="hidden" id="_token" value="{{ csrf_token() }}">


@endsection

@push('js')
<script src="{{ asset('public/backend/assets/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
   

</script>




<!-- show in word in script -->
<script>


   /*  function convertToWord(field_name)
    { */
            //Define convert amount in words funcion
            var inWords = function(totalRent) {

                var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
                var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
                var number = parseFloat(totalRent).toFixed(2).split(".");
                var num = parseInt(number[0]);
                var digit = parseInt(number[1]);
                if ((num.toString()).length > 9) return 'overflow';
                var n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
                var d = ('00' + digit).substr(-2).match(/^(\d{2})$/);
                if (!n) return;
                var str = '';
                str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
                str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
                str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
                str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
                str += (n[5] != 0) ? (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Taka ' : '';
                str += (d[1] != 0) ? ((str != '') ? "and " : '') + (a[Number(d[1])] || b[d[1][0]] + ' ' + a[d[1][1]]) + 'Paisa Only!' : 'Only!';
                return str;

            }
    //}
    // Call conver amount in words funcion

    document.getElementById('present_salary').onkeyup = function() {
        document.getElementById('present_salary_in_word').innerHTML = inWords(document.getElementById('present_salary').value);
       
    };

    document.getElementById('increment_salary').onkeyup = function() {
        document.getElementById('increment_salary_in_word').innerHTML = inWords(document.getElementById('increment_salary').value);
       
    };

</script>
<!-- show in word in script -->

<script>
    //number validator
    $.validator.addMethod('number', function(value) {
        return /^\d+(\.\d{1,2})?$/.test(value);
    }, 'Please enter Only number');

    // length validator

    $.validator.addMethod('max_length', function(value) {
        if (value.length < 11) {
            return true;
        }
    }, 'Please enter 10 digit character');

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



        $("#transaction_create_from").validate({
            rules: {
                employee_id: {
                    required: true
                }
                , present_salary: {
                    required: true
                    , number: true
                },
                increment_salary: {
                    required: true
                    , number: true
                },
                effective_date:{
                    required: true
                },
                remarks: {
                    required: true,
                },
                


            }
            , submitHandler: function(form) {
                if(checkIncrementSalary() == 1){
                    return false;
                }
                cuteAlert({
                    type: "question"
                    , title: "Confirmation"
                    , message: "Are your sure ?  set up this salary ?"
                    , confirmText: "Yes"
                    , cancelText: "No"
                }).then((e) => {
                    if (e == ("confirm")) {
                        $.ajax({
                            type: 'POST'
                            , url: '{{ route('salary.disburse.store') }}'
                            , data: $(form).serialize()
                            , beforeSend: function() {
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
                                        location.reload(true);
                                    });
                                } else if (data.status == 400) {
                                    cuteAlert({
                                        type: "warning"
                                        , title: "Warning"
                                        , message: data.message
                                        , buttonText: "ok"
                                    });

                                } else {
                                    cuteAlert({
                                        type: "error"
                                        , title: "Error"
                                        , message: data.message
                                        , buttonText: "ok"
                                    });

                                }

                                console.log(data)
                                

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

<script>
    function checkIncrementSalary()
    {
        var present_salary =  parseFloat($('#present_salary').val());
        var increment_salary = parseFloat($('#increment_salary').val());
        var check_valu = '';
        
        if(present_salary !='' && increment_salary !=''){

            if(present_salary > increment_salary){

                cuteAlert({
                        type      : "warning",
                        title     : "Warning",
                        message   : 'Sorry Increment Salary can not grater than peresent salary',
                        buttonText: "OK"
                });

                return check_valu = 1;
            }else{
                return check_valu = 0;
            }
           
            
           
        }
      
    }
</script>

@endpush