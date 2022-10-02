@extends('layouts.app')
@section('title','Password Chagne')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item active">PIN Chagne</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-6 col-md-6 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>PIN Chagne Form</h2>
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

                        <form id="commission_form" action="{{ route('password.change.save') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="code">Old PIN</label>
                                    <input type="number" placeholder="Old PIN" name="old_password"
                                        class="form-control" id="old_password" required>
                                    <div class="valid-feedback"></div>

                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="code">New PIN</label>
                                    <input type="number" placeholder="New PIN" name="password" class="form-control"
                                        id="password" autocomplete="new-password" maxlength="20" required>
                                    <div class="valid-feedback"></div>

                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="code">Confirm PIN</label>
                                    <input type="number" placeholder="Confirm PIN" name="password_confirmation"
                                        class="form-control" id="password-confirm" autocomplete="new-password" maxlength="20" required>
                                    <div class="error_feedback text-danger"></div>
                                </div>
                            </div>

                            <div
                                class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center p-0">
                                <button class="btn btn-primary  waves-effect waves-themed submit_btn"
                                    type="submit">Change Password</button>
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
$('#password-confirm').on('keyup', function() {
    var password = $('#password').val();
    var password_confirm = $('#password-confirm').val();
    if (password != '') {
        if (password_confirm === password) {

            $('.error_feedback').html('');

        } else {

            $('.error_feedback').html('Sorry Password not match');


        }
    }

});
</script>



<script>



// $(function() {
//     var $form = $(this);
//     $.validator.setDefaults({
//         errorClass: 'help-block',
//         highlight: function(element) {
//             $(element)
//                 .closest('.form-group')
//                 .addClass('has-error');
//         },
//         unhighlight: function(element) {
//             $(element)
//                 .closest('.form-group')
//                 .removeClass('has-error');
//         }
//     });



//     $("#commission_form").validate({
//         rules: {
//             old_password: {
//                 required: true
//             },
//             password: {
//                 required: true,

//             },
//             password_confirmation: {
//                 required: true,


//             }
//         },
//         submitHandler: function(form) {

//             var password = $('#password').val();
//             var password_confirm = $('#password-confirm').val();

//             if (password === password_confirm) {


//                 cuteAlert({
//                     type: "question",
//                     title: "Confirmation",
//                     message: "Are your sure ? Change this Password",
//                     confirmText: "Yes",
//                     cancelText: "No"
//                 }).then((e) => {
//                         if (e == ("confirm")) {
//                             $.ajax({
//                                 type: 'POST',
//                                 url: '{{ route("password.change.save") }}',
//                                 data: $(form).serialize(),
//                                 beforeSend: function() {
//                                     loaderStart();
//                                 },
//                                 success: (data) => {
//                                     if (data.status == 200) {
//                                         cuteAlert({
//                                             type: "success",
//                                             title: "Success",
//                                             message: data.message,
//                                             buttonText: "ok"
//                                         }).then((e) => {
//                                             location.reload(true);
//                                         });
//                                     } else if (data.status == 400) {

//                                         cuteAlert({
//                                             type: "warning",
//                                             title: "Warning",
//                                             message: "Sorry product type not match",
//                                             buttonText: "ok"
//                                         })


//                                     } else {

//                                         alert(data.message);
//                                     }

//                                     console.log(data);


//                                 },
//                                 error: function(data) {
//                                     console.log(data);
//                                 },
//                                 complete: function() {
//                                     loaderEnd();
//                                 }
//                             });
//                             $form.submit();
//                         }
                     
//                     })
//                 }
//             }
//     });
// });
</script>

@endpush