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

      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">

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


            .footer {
               height: 30px;
              position: fixed;
              left: 0;
              bottom: 0;
              width: 100%;
              background-color: #fff;
              color: black;
              text-align: center;
              font-size: 12px !important;
            }
            

            .navbar-light .navbar-nav .show > .nav-link, .navbar-light .navbar-nav .active > .nav-link, .navbar-light .navbar-nav .nav-link.show, .navbar-light .navbar-nav .nav-link {
                    color: rgb(9 165 225);
                    font-size: 11px;
                    
                    
                }



            .navbar-light .navbar-nav .show > .nav-link, .navbar-light .navbar-nav .active > .nav-link, .navbar-light .navbar-nav .nav-link.show, .navbar-light .navbar-nav .nav-link.active {
                    color: rgb(9 165 225);
                   
                }

            .navbar-light .navbar-nav .nav-link {
                color: rgb(0 0 0 / 95%);
            }

            nav.navbar.navbar-expand-lg.navbar-light.bg-light{
                 margin-left: 6%;
            } 





         body {
            font-family: 'SolaimanLipi', Arial, sans-serif !important;
        }
    
    .terms i{
        color: #04a5e1;
    }


    
         @media only screen and (max-width: 990px) {
            .for_mobile{
                display: block !important;
            }

            .for_big_sc{
                display: none !important;
            }

        }

        

        .custom-img:hover{
        	transform: scale(2);
        	z-index: 9999;
        	transition-duration: 1s;
        	position: relative;
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

                             <div class="ml-auto">
                                
                                  <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-left: 0%;">
                                  
                                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                  </button>
                                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                    <ul class="navbar-nav">
                                      <li class="nav-item active">
                                       
                                        <span class="nav-link" style="color: #0C83E2;"> <b><i style="font-weight: bold;font-size: 14px;" class="fas fa-phone-volume"></i> 017102693230 </b></span>
                                      </li>

                                       <li class="nav-item">

                                        <span class="nav-link" > 
                                          @php $locale = session()->get('locale'); @endphp
                                          @switch($locale)
                                              @case('bn')
                                                <?php  
                                                  $bangla_color = "#fd3995"; 
                                                  $english_color = "#04a6e1";
                                                ?> 
                                              @break                                               
                                              @default
                                              <?php 
                                                $bangla_color = "#04a6e1"; 
                                                $english_color = "#fd3995";
                                              ?>
                                          @endswitch

                                          <a href="{{ route('language', ['bn']) }}" style="color: {{ $bangla_color }}"> বাংলা  </a> 
                                          | 
                                          <a href="{{ route('language', ['en']) }}" style="font-size:  10px ;color: {{ $english_color }}">ENGLISH</a> 
                                        </span>

                                      </li>
                                     
                                    </ul>
                                  </div>
                                </nav>
                                
                            </div>

                            
                        </div>
                    </div>

                    
                    

                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            
                            <div class="row">

                                

                                <div class="col-md-12 col-xs-12 col-sm-12">
                                     
                                     <div class="row text-center text-lg-start">

								    <div class="col-lg-3 col-md-4 col-6">
								      <a  href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/pWkk7iiCoDM/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/aob0ukAYfuI/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/EUfxH-pze7s/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/M185_qYH8vg/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/sesveuG_rNo/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/AvhMzHwiE_0/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/2gYsZUmockw/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/EMSDtjVHdQ8/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/8mUEy0ABdNE/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/G9Rfc1qccH4/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/aJeH0KcFkuc/400x300" alt="">
								      </a>
								    </div>
								    <div class="col-lg-3 col-md-4 col-6">
								      <a href="#" class="d-block mb-4 h-100">
								        <img class="img-fluid img-thumbnail custom-img" src="https://source.unsplash.com/p2TQ-3Bh3Oo/400x300" alt="">
								      </a>
								    </div>
								  </div>

                                </div>
                            
                        </div>

                            

                        </div>
                    </div>

                   
                </div>
            </div>
        </div>



  <footer class="footer navbar-fixed-bottom for_big_sc">
            
                <div class="row">
                    <div class="col-md-6">
                        <p class="mt-2" style="margin-right: 26%;">&copy; @lang('landing.copyright') </p>
                    </div>

                    <div class="col-md-6">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">                 
                            <ul class="navbar-nav mr-auto" style="margin-top: -7px;">

                            <li class="nav-item active">
                                <a class="nav-link" href="{{url('/')}}">@lang('landing.home')   <span class="sr-only">(current)</span> <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li>

                              <!-- <li class="nav-item ">
                                <a class="nav-link" href="#">@lang('landing.Terms')   <span class="sr-only">(current)</span> <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li> -->

                              <li class="nav-item">
                                <a class="nav-link" download="" href="{{ asset('public/saller/Seller Form.pdf') }}">@lang('landing.registration_form')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a> 
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" href="#"> @lang('landing.about_us')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li>

                                <li class="nav-item">
                                <a class="nav-link" href="{{url('contact')}}">@lang('landing.contact_us')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" href="{{url('/gallary')}}">@lang('landing.gallary')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" href="https://www.facebook.com/venturenxt" target="_blank" ><b><i class="fab fa-facebook-square" style="color: #27a7e2;font-size: 18px;"></i></b></a>
                              </li>
                              
                            </ul>
                           
                         
                        </nav>
                    </div>
                </div>
            
        </footer>


        <div class="row for_mobile" style="margin-top: 10%;display: none;">
            <div class="col-md-12">

               


                <ul class="list-group text-center">
                  <li class="list-group-item"><a class="nav-link" href="{{url('/')}}"> @lang('landing.home') </a></li>
                  <!-- <li class="list-group-item"><a class="nav-link" href="#">@lang('landing.Terms') </a> </li> -->
                  <li class="list-group-item"><a class="nav-link" download="" href="{{ asset('public/saller/Seller Form.pdf') }}">@lang('landing.registration_form') </a> </li>
                  <li class="list-group-item"><a class="nav-link" href="#">@lang('landing.about_us') </a></li>
                  <li class="list-group-item"><a class="nav-link" href="{{url('/contact')}}">@lang('landing.contact_us') </a> </li>
                  <li class="list-group-item"><a class="nav-link" href="{{url('/gallary')}}">@lang('landing.gallary') </a> </li>
                  <li class="list-group-item"> @lang('landing.copyright')  </li>
                  
                </ul>

            </div>
        </div>

      
    </body>
</html>

