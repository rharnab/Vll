@extends('layouts.app')
@section('title','Account | Transaction')

@push('css')

<link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">

@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Account</li>
            <li class="breadcrumb-item active">Create Transaction</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-12 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Transaction  Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="transaction_create_from" action="{{ route('account.transaction.store') }}" method="post" enctype="multipart/form-data">

                            	@csrf

                                <div class="row">

                                <div class="col-md-6">
                                    
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="account_name"> Account Name </label>
                                            
                                            <select class="form-control select2" name="account_name" id="account_name" required>
                                                <option value="s">Select Account Name</option>
                                                @foreach($accounts as $single_account)
                                                <option value="{{ $single_account->gl_account_no }}"> {{ $single_account->acc_name }} </option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">
                                            </div>
                                        </div>



                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="account_number">Account Number </label>
                                            <input type="text" placeholder="Account Number" name="show_account_number" class="form-control" id="show_account_number"  required readonly>
                                            <div class="valid-feedback"></div>
                                        
                                        </div>


                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="tran_type"> Transaction type </label>
                                            <select class="form-control select2" name="tran_type" id="tran_type" required>
                                                <option value="">Select Type</option>    
                                                <option value="1">Deposit</option>
                                                <option value="2">Withdraw</option>
                                            
                                            </select>
                                            <div class="valid-feedback">
                                            </div>

                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="payment_type"> Payment Way </label>
                                            <select class="form-control select2" name="payment_type" id="payment_type" required>
                                                <option value="">Select Payment</option>    
                                                <option value="1">Cash</option>
                                                <option value="2">Bank A/C No</option>
                                            
                                            </select>
                                            <div class="valid-feedback">
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3" id="chq_area" style="display: none">
                                            <label class="form-label" for="chq_number">Cheque No</label>
                                            <input type="text" placeholder="Cheque No"  name="chq_number" class="form-control" id="chq_number">
                                            <div class="valid-feedback"></div>
                                        
                                        </div>


                                       

                                </div>


                                <div class="col-md-6">

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="amount"> Amount </label>
                                            <input type="text" placeholder="Amount" name="amount" class="form-control" id="amount"  required>
                                            <div class="valid-feedback"></div>
                                            <small id="amount_in_word" style="color: red; font-weight:bold; text-transform:capitalize"></small>
                                        </div> 
                                        

                                       

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="user">Receive / Payee</label>
                                            <!-- <input type="text" placeholder="User" name="user" class="form-control" id="user"  required> -->
                                            <select class="form-control select2" name="user" id="user" required>
                                                <option value="">Select Name</option>    
                                               @foreach($users as $single_user)
                                               <option value="{{ $single_user->id }}">{{ $single_user->name }}</option>
                                               @endforeach
                                            
                                            </select>
                                            <div class="valid-feedback"></div>

                                        </div>


                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="entry_date"> Date </label>
                                                <input type="text"  value="<?php echo date('m/d/Y'); ?>"  name="entry_date" class="form-control" id="entry_date"  required>
                                            <div class="valid-feedback"></div>

                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="remarks"> Remarks </label>
                                            <input type="text" placeholder="Remarks" name="remarks" class="form-control" id="remarks"  required>
                                            <div class="valid-feedback"></div>

                                        </div>


                                        

                                        

                                </div> 
                
                            </div>

                             <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center p-2">
                                <button class="btn btn-primary  waves-effect waves-themed submit_btn" type="submit">Submit form</button>
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


<script>
    $('#account_name').on('change', function(){
        var account_name = $('#account_name').val();

        if(account_name !='')
        {
            $('#account_number').val(account_name)
            $('#show_account_number').val(account_name);
            $('#show_account_number').attr('readonly', true)
        }else{
            $('#account_number').val('');
        }
       

    });
</script>

<!-- show in word in script -->
<script>
   //Define convert amount in words funcion
   var inWords = function(totalRent){
            
            var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
            var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
            var number = parseFloat(totalRent).toFixed(2).split(".");
            var num = parseInt(number[0]);
            var digit = parseInt(number[1]);
            if ((num.toString()).length > 9)  return 'overflow';
            var n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            var d = ('00' + digit).substr(-2).match(/^(\d{2})$/);
            if (!n) return; var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Taka ' : '';
            str += (d[1] != 0) ? ((str != '' ) ? "and " : '') + (a[Number(d[1])] || b[d[1][0]] + ' ' + a[d[1][1]]) + 'Paisa Only!' : 'Only!';
            return str;
            
        }
        // Call conver amount in words funcion
            document.getElementById('amount').onkeyup = function () {
            document.getElementById('amount_in_word').innerHTML = inWords(document.getElementById('amount').value);
        };

</script>

<!-- show in word in script -->

<script>

        // $.validator.addMethod('max_amount', function (value) {
        //     if (value >= 1000000000) {
        //         return false;
        //     } else {
        //         return true;
        //     }
        // }, "Amount should not above 100 core");

        //number validator
        $.validator.addMethod('number', function(value) {
            //return /^\d+$/.test(value);
            return /^\d+(\.\d{1,2})?$/.test(value);
        }, 'Please enter Only number');

        // length validator
        
        $.validator.addMethod('max_length', function(value) {
        if(value.length < 11)
        {
        return true;
        }
        }, 'Please enter 10 digit character');
        
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

        

            $("#transaction_create_from").validate({
                rules: {
                    account_name: { required: true},
                    account_number: { required: true, number: true},
                    show_account_number: { required: true, number: true},
                    tran_type: { required: true},
                    amount: { required: true, number: true, max_length: true},
                    entry_date: { required: true },
                    remarks: { required: true},
                    payment_type: {required: true},
                    chq_number: {max_length: true}    
                },
                submitHandler: function(form) {
                   
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
                                url: '{{ route('account.transaction.store') }}',
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
    $('#payment_type').on('change', function(){
        var payment_type = $('#payment_type').val();

        if(payment_type == 2)
        {
            $('#chq_area').css('display', 'block');
            $('#chq_number').attr('required', true)
        }else{
            $('#chq_area').css('display', 'none');
            $('#chq_number').attr('required', false);
            $('#chq_number').val('');
            
        }

    });
</script>

<script>
$( function() {
    $( "#entry_date" ).datepicker({
        dateFormat:"mm/dd/yy",
        });
    });

</script>


@endpush
