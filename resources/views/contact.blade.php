<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>
            VLL | login
        </title>
        <meta name="description" content="Login">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- base css -->
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/vendors.bundle.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/app.bundle.css') }}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/backend/assets/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/backend/assets/img/favicon/favicon-32x32.png') }}">
        <link rel="mask-icon" href="{{ asset('public/backend/assets/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <!-- Optional: page related CSS-->
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/fa-brands.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/fa-solid.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/custom.css') }}">

      <link rel="stylesheet" href="{{ asset('public/backend/assets/css/theme_color.css') }}">
      <link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">
      <style>
            ul{
                font-size: 14px;
            }

            @media only screen and (max-width: 767px) {
              .reset_btn {
                display: none;
              }
            }
            .logo{
                width: 200px!important;
            }


      </style>
    </head>
    <body>
        <div class="page-wrapper">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                                <a href="{{url('/')}}" class="page-logo-link press-scale-down d-flex align-items-center">
                                    <img src="{{ asset('public/backend/assets/img/vll.png') }}" class="logo" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                    <span class="page-logo-text mr-1"></span>
                                </a>
                            </div>
                            <a href="{{url('contact-us')}}" class="ml-auto">
                                Contact Us
                            </a>
                        </div>
                    </div>
                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 hidden-sm-down">
                                    <h2 class="fs-xxl fw-500 mt-4 text-white"> </h2>
                                    
                                    <div class="terms" style="background-color: white;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;padding-right: 10px">
                                        
                                        <table class="table table-bordered">
                                        	<tr>

                                        		<th>##</th>
                                        		<th>নাম </th>
                                        		

                                        	</tr>

                                        	<tr>
                                        		<td>মার্কেটিং </td>
                                        		<td>ফয়সাল  </td>
                                        		
                                        	</tr>


                                        	<tr>
                                        		<td>টেকনিক্যাল </td>
                                        		<td>নিশাদ </td>
                                        		
                                        	</tr>


                                        	<tr>
                                        		<td>মার্কেটিং দ্রব্য </td>
                                        		<td>জিতু </td>
                                        		
                                        	</tr>

                                        	<tr>
                                        		<td>তথ্য </td>
                                        		<td>তুষার </td>
                                        		
                                        	</tr>

                                        </table>

                                        <a style="color: red;text-decoration: underline !important;" href="{{url('public/backend/assets/Seller Form.pdf')}}" download>দোকান নিবন্ধন ফর্ম ডাউনলোড করুন  </a>
                                    </div>
                                </div>

                               
                            </div>
                            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                                2021 - {{ date('Y') }} © VLL Socks by&nbsp;<a href='' class='text-white  fw-500' title='' target='_blank'>venturenxt.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('public/backend/assets/js/vendors.bundle.js') }}"></script>
        <script src="{{ asset('public/backend/assets/js/app.bundle.js') }}"></script>
        <script src="{{ asset('public/backend/assets/js/formplugins/validator/validate.min.js') }}"></script>
        <script src="{{ asset('public/backend/assets/js/validator/formplugins/additional-method.min.js') }}"></script>
        <script>

        // nid image upload form validation
        $(function() {

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





            $("#login-form").validate({
                rules: {
                    email: {
                        required           : true,
                    },
                    password: {
                        required : true,
                        minlength: 6
                    },
                },
                messages: {
                    user_login_id: {
                        required           : 'please enter your mobile number',
                    },
                    password: {
                        required : "please enter your password",
                        minlength: 'password al-least 6 caracter/word'
                    }
                },
            });

        });
        </script>
    </body>
</html>

