@extends('layouts.app')
@section('title','Salary | Disburse')

@push('css')

<link rel="stylesheet" media="screen, print"
    href="{{ asset('public/backend/assets/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">

    <style>
        .list-group-item-primary {
            color: black;
           
        }
    </style>

@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item active">Salary Amendment</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-6 col-md-6 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>Salary Amendment Form</h2>
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
                                        <input type="text" class="form-control"   value="{{ $salary_info['name'] }}" readonly>
                                        <div class="valid-feedback">
                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="disburse_month"> Salary Disburse Month </label>
                                        <input type="text"  name="disburse_month" value="{{ $salary_info['disburse_month']  }}"  class="form-control"  readonly>
                                        <div class="valid-feedback"></div>
                                    </div>

                                   

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="total_salary">Monthly  Salary </label>
                                        <input type="text" placeholder="Total Salary" id="total_salary" value="{{ $salary_info['monthly_salary']  }}"   class="form-control"  readonly>
                                        <div class="valid-feedback"></div>
                                        <small id="total_salary_in_word" style="color: red; font-weight:bold; text-transform:capitalize"></small>
                                    </div> 

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="salary_amount">Due Salary Amount</label>
                                        <input type="text" placeholder="Salary Amount" value="{{ $salary_info['due_salary_amount']  }}"  class="form-control"  id="salary_amount" readonly>
                                        <div class="valid-feedback"></div>
                                        <small id="salary_amount_in_word" style="color: red; font-weight:bold; text-transform:capitalize"></small>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="disburse_amount">Disburse Amount </label>
                                        <input type="text" placeholder="Disburse Amount"  name="disburse_amount" id="disburse_amount" value="{{ $salary_info['disburse_amount'] }}" class="form-control"   required>
                                        <div class="valid-feedback"></div>
                                        <small id="disburse_amount_in_word" style="color: red; font-weight:bold; text-transform:capitalize"></small>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="remarks"> Remarks </label>
                                        <input type="text" placeholder="Remarks" name="remarks" id="remarks" value="{{ $salary_info['remarks'] }}" class="form-control" id="remarks" >
                                        <div class="valid-feedback"></div>

                                    </div>

                                </div>

                            </div>

                            <div
                                class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center p-2">
                                <input type="hidden" name="amendment_id" id="amendment_id" value="{{ $salary_info['amendment_id'] }}">
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

    document.getElementById('disburse_amount').onkeyup = function() {
        document.getElementById('disburse_amount_in_word').innerHTML = inWords(document.getElementById('disburse_amount').value);
        CheckDisburseAmount() // recall disburse check amount 
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
                , disburse_month: {
                    required: true
                },
                disburse_amount: {
                    required: true
                    , number: true
                },
                amendment_id:{
                    required: true
                }
              
            }
            , submitHandler: function(form) {
                cuteAlert({
                    type: "question"
                    , title: "Confirmation"
                    , message: "Are your sure ?  Disburse this salary ?"
                    , confirmText: "Yes"
                    , cancelText: "No"
                }).then((e) => {

                      
                        if(CheckDisburseAmount() == 0)
                        {
                            cuteAlert({
                                    type      : "warning",
                                    title     : "Warning",
                                    message   : 'Sorry disburse amount can not grater than due salary amount',
                                    buttonText: "ok"
                            });
                            return false;
                        }
                        

                    if (e == ("confirm")) {
                        $.ajax({
                            type: 'POST'
                            , url: '{{ route('salary.disburse.amendment_update') }}'
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
                                        window.location.href = "{{ route('salary.disburse.authorize') }}"
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
    function CheckDisburseAmount()
    {
      var disburse_amount  = $('#disburse_amount').val();
      var salary_amount  = $('#salary_amount').val();
      var result = '';
       if(parseFloat(disburse_amount) !='')
       {
           if(parseFloat(disburse_amount) > parseFloat(salary_amount)){
               return result  = 0;
           }else{
               return result  = 1;
           }
       }
      
    }
</script>



@endpush