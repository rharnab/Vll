<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>
            Pegasus | login
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
                                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
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
                                <div class="col col-md-6 col-lg-7 hidden-sm-down">
                                    <h2 class="fs-xxl fw-500 mt-4 text-white">Welcome To Our Stock Management Software </h2>
                                    
                                    <div class="terms" style="background-color: white;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;padding-right: 10px">
                                        <h2 style="text-align:center;"> বিশেষ শর্তাবলী</h2>
                                        <p>১. প্রতি আলনায় একশত জোড়া মোজা থাকিবে।</p>
                                        <p>২. প্রতি মাসের মোজা বিক্রয়ের মূল্য আমাদের প্রতিনিধি পরবর্তী মাসের ৫ তারিখের মধ্যেই সংগ্রহ করিবে এবং কমিশিনের অংশ দোকানদারকে নগদ বুঝিয়ে দিবে।</p>

                                        <p>৩. প্রতি পনের দিন অন্তর আমাদের প্রতিনিধি বিগত পনের দিনে যে পরিমান মোজা বিক্রয় হইবে তাহার সমপরিমান মোজা আলনায় সরবরাহ করিবে। এছাড়াও আলনার মোজা অধিকাংশ বিক্রয় হয়ে গেলে বিক্রেতাদের যোগাযোগের (ফোন) ভিত্তিতে নতুন মোজা সরবরাহ করা হইবে।</p>

                                        <p>৪. প্রতিবার আলনার মোজা রিফিল করার পর বিক্রেতা তা সচক্ষে বুঝে নিয়ে VENTURE LIFESTYLE LTD এর চালান রশিদ গ্রহন করিবেন এবং এক কপি রশিদ সই করিয়া নির্ধারিত VENTURE LIFESTYLE LTD এর বিক্রয় প্রতিনিধিকে বুঝিয়ে দিবেন।</p>

                                        <p>৫. বছরের বিভিন্ন সময় এবং বিভিন্ন উৎসবগুলোতে VENTURE LIFESTYLE LTD এর পক্ষ হইতে বিশেষ পুরুস্কার এর ব্যবস্থা করা হয়।</p>

                                        <p>৬. VENTURE LIFESTYLE LTD বিভিন্ন সময়ে এর মাধ্যমে প্রোমোশনাল অফারগুলো জানিয়ে দেয়। তাই দোকান নিবন্ধনের সময় বিক্রেতাদের সঠিক নম্বর প্রদান করা অত্যন্ত জরুরী।</p>

                                        <p>৭. প্রতি মাসে সর্বনিম্ন একশত জোড়া মোজা অবশ্যই বিক্রয় করিতে হইবে। উল্লেখ্য যে, কেবলমাত্র প্রথম তিন মাসে দুই শত জোড়া বিক্রয়ের সুযোগ থাকিবে।</p>

                                        <p>৮. বিক্রেতাগনদের ওয়েব প্যানেল ব্যবহার করে প্রতিনিয়ত তার র‌্যাক এর মোজার স্টক আপডেট রাখতে হবে।</p>

                                        <p>৯. VENTURE LIFESTYLE LTD এর আলনায় VENTURE LIFESTYLE LTD এর মোজা ব্যতীত অন্য কোন মোজা বা পন্য রাখা যাইবে না। একইভাবে VENTURE LIFESTYLE LTD এর আলনার মোজা অন্য কোথাও রাখা যাবে না।</p>


                                        <p>১০. VENTURE LIFESTYLE LTD যে কোন সময় কমিশনের পরিমান পরিবর্তন করার অধিকার সংরক্ষণ করে।</p>

                                        <p>১১. সকল মোজার প্যাকেটের উপর লিখিত মূল্য ভ্যাট-ট্যাক্স বহির্ভূত।</p>

                                        <p>১২. নিবন্ধন ফর্মটির সাথে দোকানের মালিকের ১ কপি পাসপোর্ট সাইজ ছবি ও NID/SMART কার্ডের ফটোকপি জমা দিতে হবে।</p>

                                        <p>১৩. উপরে বর্নিত নিয়মাবলীর এক বা একাধিক নিয়ম যদি কোনো বিক্রেতা ইচ্ছাকৃতভাবে ভঙ্গ করেন তাহলে আলনা এবং আলনার সকল মোজা যেকোন মুহূর্তে VENTURE LIFESTYLE LTD কতৃপক্ষ ফেরত নেয়ার অধিকার সংরক্ষন করে।</p>

                                        <h4>নিম্নোক্ত ছক অনুযায়ী সম্মানিত বিক্রেতাগণ তাদের লভ্যাংশ বুঝিয়া পাইবেনঃ</h4>

                                        <table class="table table-bordered" >
                                            <tr>
                                                <th rowspan="1">বিক্রেদের প্রতি ১০০জোড়া বিক্রিতে লাভের পরিমান </th>
                                                <th>১-১১৯ জোড়া </th>
                                                <th>১২০ থেকে ১৯৯ জোড়া </th>
                                                <th>২০০ জোড়া এবং তার অধিক   </th>
                                            </tr>


                                            <tr>
                                                <td ></td>
                                                <td rowspan="1">২০ %</td>
                                                <td rowspan="1">২২ %</td>
                                                <td rowspan="1">২৫ % </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                                    <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                                        Secure login
                                    </h1>
                                    <div class="card p-4 rounded-plus bg-faded">
                                        @if(Session::get('errors') || count( $errors ) > 0)
                                            @foreach ($errors->all() as $error)
                                                <span style="color: red; font-weight:bold; font-size:12px;"><strong>{{ $error }}</strong></span>
                                                <hr>
                                            @endforeach
                                        @endif
                                        <form id="login-form" name="login-form" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label" for="email"> Mobile  Number </label>
                                                <input type="text" autocomplete="off" id="email" name="email" class="form-control form-control-lg" placeholder="Mobile Number" required>                                              
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" autocomplete="off" id="password" name="password" class="form-control form-control-lg" placeholder="password"  required>                                               
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-lg-6 pr-lg-1 my-2 reset_btn">
                                                    <button type="reset" class="btn btn-info btn-block btn-lg ">Reset &nbsp;<i class="fas fa-sync-alt"></i></button>
                                                </div>
                                                <div class="col-lg-6 pl-lg-1 my-2">
                                                    <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg">Login &nbsp;<i class="far fa-sign-in-alt"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                                2021 - {{ date('Y') }} © Pegasus Socks by&nbsp;<a href='' class='text-white  fw-500' title='' target='_blank'>venturenxt.com</a>
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

