<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>
             Venture Life Style Ltd
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

        <link rel="stylesheet" media="screen, print" href="{{ asset('public/responsive.css') }}">

      <link rel="stylesheet" href="{{ asset('public/backend/assets/css/theme_color.css') }}">
      <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
      <link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

      <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">

      <style>

        .mobile_menu{
          display:none;
        }

       


        @media screen and (max-width: 991px) {

          nav.navbar.navbar-expand-lg.navbar-light.bg-light{
                  display:none;
                }

          .nav-link {
              display: block;
              padding: 2px 0px;
          }

          .mobile_menu{
            display:block;
          }


         .card{
            margin-bottom: 23px;
         }


        }
       
      </style>

      @stack('css')


        
   <!-- Your Chat Plugin code -->
   <div id="fb-root"></div>
    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "110550761466578");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>
    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    
      <style>
            body{
                font-size: 16px;
                
            }
            ul{
                font-size: 14px;
            }

            @media only screen and (max-width: 767px) {
              .site-head{
                  margin: 0 0 40px 0;
              }
              .reset_btn {
                display: none;
              }
            .shop-slide, .shop-login{
                margin: 0 0 50px 0 !important;
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

    .table-bordered th, .table-bordered td {
            border: 1px solid grey;
                padding: 4px !important; 
        }


        

        @media only screen and (max-width: 990px) {
            .for_mobile{
                display: block !important;
            }

            .for_big_sc{
                display: none !important;
            }



        }



      .highlight{
            color: #fd1381;
        }

      </style>


       @stack('css')
       
    </head>
    <body>
        <div class="page-wrapper">
            <div class="page-inner bg-brand-gradient" style="background-color: #25AAE2;">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient site-head">
                         <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                                <a href="{{url('/')}}" class="page-logo-link press-scale-down d-flex align-items-center">
                                    <img src="{{ asset('public/backend/assets/img/vll.png') }}" class="logo" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                    <span class="page-logo-text mr-1"></span>
                                </a>
                            </div>


                            <div class="ml-auto ">
                                
                                <ul class="navbar-nav mobile_menu">
                                      <li class="nav-item ">
                                       
                                        <span class="nav-link" style="color: #0C83E2;font-size:12px;"> <b><i style="font-weight: bold;font-size: 14px;" class="fas fa-phone-volume"></i> 01783863638 </b></span>
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
                                          

                                           <a href="#" style="filter: blur(1px); font-size:  10px ;color: {{ $english_color }}">ENGLISH</a> 
                                        </span>

                                      </li>
                                     
                                    </ul>

                                <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-left: 0%;">
                                  
                                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                  </button>
                                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                    <ul class="navbar-nav">
                                      <li class="nav-item active">
                                       
                                        <span class="nav-link" style="color: #0C83E2;"> <b><a href="tel:01783863638"><i style="font-weight: bold;font-size: 14px;" class="fas fa-phone-volume"></i> 01783863638</a>  </b></span>
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
                                          <a href="#" style="filter: blur(1px); font-size:  10px ;color: {{ $english_color }}">ENGLISH</a> 
                                        </span>

                                      </li>
                                     
                                    </ul>
                                  </div>
                                </nav>
                                
                            </div>


                        </div>
                    </div>