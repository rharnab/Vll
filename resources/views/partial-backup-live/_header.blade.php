
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>
           VLL | @yield('title')
        </title>
        <meta name="description" content="Marketing Dashboard">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">

        <!-- base css -->
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/vendors.bundle.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/app.bundle.css') }}">

        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/fa-solid.css') }}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/backend/assets/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/backend/assets/img/favicon/favicon-32x32.png') }}">
        <link rel="mask-icon" href="{{ asset('public/backend/assets/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
     
        <link rel="stylesheet" href="{{ asset('public/backend/assets/cute-alert/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/backend/assets/css/custom.css') }}">
        
        <link rel="stylesheet" media="screen, print" href="{{ asset('public/backend/assets/css/formplugins/select2/select2.bundle.css') }}">



         <link rel="stylesheet" href="{{ asset('public/backend/assets/css/theme_color.css') }}">
         
        
        @stack('css')
      



        <style>
            .panel-toolbar {
                display: none;
            }
            span.required_star {
                font-weight: bold;
                color: red;
            }


            .mod-nav-link:not(.nav-function-top):not(.nav-function-minify):not(.mod-hide-nav-icons) ul.nav-menu:not(.nav-menu-compact) > li > ul > li a:after {

                    content: "";
                    display: block;
                    position: absolute;
                    width: 0px !important;

                    height: 0px !important;

                    background-color: none !important;
                    left: 0px !important;

                    top: 0px !important;

                    border: 0px !important;
                    border-radius: 0px !important;
                    z-index: 1;
                }

            .mod-nav-link:not(.nav-function-top):not(.nav-function-minify):not(.mod-hide-nav-icons) ul.nav-menu:not(.nav-menu-compact) > li > ul:before {
                
                content: "";
                display: block;
                position: absolute;
                z-index: 1;
                left: 0px !important;
                top: 0px !important;
                bottom:0px !important;
                border-left: 0px !important;
            
            } 
            
            .nav-menu li > ul:hover{
                background-color: rgb(12 163 225) !important;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .nav-menu li > ul {
                background-color: rgb(4 166 225) !important;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .nav-menu li > ul li:hover {
                    background: none;
                    color: black;
                }
            
                .nav-menu li > ul li > ul li a:hover {
                    color: black;
                    padding: 0.8125rem 2rem 0.8125rem 4.75rem;
                }


            .nav-menu li > ul:hover{
                background-color: rgb(12 163 225) !important;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .nav-menu li > ul {
                background-color: rgb(4 166 225) !important;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .nav-menu li > ul li:hover {
                    background: none;
                    color: black;
                }
            
                .nav-menu li > ul li > ul li a:hover {
                    color: black;
                    padding: 0.8125rem 2rem 0.8125rem 4.75rem;
                }

        </style>
    </head>