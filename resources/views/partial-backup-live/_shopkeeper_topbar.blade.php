<style type="text/css">
    @import "//netdna.bootstrapcdn.com/font-awesome/3.0/css/font-awesome.css";

.mainLoginInput{
  height: 40px;
  padding: 0px;
  font-size: 30px;
  margin: 5px 0;
}

.mainLoginInput::-webkit-input-placeholder { 
font-family: FontAwesome;
font-weight: normal;
overflow: visible;
vertical-align: top;
display: inline-block !important;
padding-left: 5px;
padding-top: 2px;
color: hsl(9, 40%, 60%);
}

.mainLoginInput::-moz-placeholder  { 
font-family: FontAwesome;
font-weight: normal;
overflow: visible;
vertical-align: top;
display: inline-block !important;
padding-left: 5px;
padding-top: 2px;
color: hsl(9, 40%, 60%);
}

.mainLoginInput:-ms-input-placeholder  { 
font-family: FontAwesome;
font-weight: normal;
overflow: visible;
vertical-align: top;
display: inline-block !important;
padding-left: 5px;
padding-top: 2px;
color: hsl(9, 40%, 60%);
}


.bg-danger-400 {
    background-color: #25AAE2;
    color: white;
}

.bg-danger-200 {
    background-color: #25AAE2;
    color: rgba(0, 0, 0, 0.8);
}

.bg-danger-300{

     background-color: #25AAE2;
    color: rgba(0, 0, 0, 0.8);
}

.btn-danger.disabled, .btn-danger:disabled {
    color: #fff;
    background-color: #25AAE2;
    border-color: #25AAE2;
}

.navbar-nav .nav-link {
    margin-top: 15px;
    padding-right: 60px;
}

.search {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: none !important;
}

</style>

<header class="page-header" role="banner">
    <!-- we need this logo when user switches to nav-function-top -->
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">SmartAdmin WebApp</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- DOC: nav menu layout change shortcut -->
    <!-- <div class="hidden-md-down dropdown-icon-menu position-relative">
        <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
            <i class="ni ni-menu"></i>
        </a>
        <ul>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation">
                    <i class="ni ni-minify-nav"></i>
                </a>
            </li>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Lock Navigation">
                    <i class="ni ni-lock-nav"></i>
                </a>
            </li>
        </ul>
    </div> -->
    <!-- DOC: mobile button appears during mobile width -->
   <div class="hidden-sm-up">
        <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on" data-focus="search-field" title="Search">
            <i class="fal fa-search"></i>
        </a>
    </div>





    <div class="search">
        <form class="app-forms hidden-xs-down" role="search" action="#" autocomplete="off">
            <input type="text" id="search-field"  placeholder="&#61442; @lang('landing.search_socks')" onkeyup="searchSocks()" class="form-control search_socks_code mainLoginInput" tabindex="1">

            <a href="#" onclick="return false;" class="btn-danger btn-search-close js-waves-off d-none" data-action="toggle" data-class="mobile-search-on">
                <i class="fal fa-times"></i>
            </a>
        </form>
    </div>

     <!-- app settings -->
     <div class="hidden-md-down" style="margin: 0 auto;text-align: center; margin-left: 31%;">
          <a href="#" class="header-icon" style="text-transform: uppercase">
              <b> {{ Auth::user()->name }}</b>
           </a> 
       </div>
       <!-- app shortcuts -->

    <div class="ml-auto d-flex">

    <ul class="navbar-nav">
                                      
        
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
            <a href="{{ route('language', ['en']) }}" style="color: {{ $english_color }}">ENGLISH</a> 
        </span>

        </li>

        
         
    </ul>

        <!-- refill-voucher -->
        {{-- <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
                <i class="fal fa-money-bill-alt"></i>
                <span class="badge badge-icon"> @php echo DB::table('shop_refill_voucher')->where('shop_id', Auth::user()->shop_id )->count();  @endphp </span>
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
                    <h4 class="m-0 text-center color-white">
                        @lang('landing.product_refill_voucher')
                    </h4>
                </div>
                
                <div class="custom-scroll h-100">
                    <ul class="notification">

                        @php
                        $all_voucher=  DB::table('shop_refill_voucher')->where('shop_id', Auth::user()->shop_id )->orderBy('id', 'Desc')->get();
                        @endphp

                        @foreach($all_voucher as $voucher)

                        <li class="unread">
                            <a href="{{ asset('public/'.$voucher->store_location) }}" class="d-flex align-items-center" download>
                                {{ $voucher->voucher_name }}
                            </a>
                        </li>

                        @endforeach

                    </ul>
                </div>
                
            </div>
        </div> --}}
         <!-- refill-voucher -->


          <!-- Cash-voucher -->
       <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
                <i class="fal fa-inbox"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
                    <h4 class="m-0 text-center color-white">
                       @lang('landing.rack_fillup_reqeust')
                    </h4>
                </div>
                
                <div class="custom-scroll h-100" style="padding: 20">
                    <div class="panel-container show">
                        <div class="panel-content" style="padding: 30px!important">
                            <form id="message_form" >                                
                                <div class="form-group">
                                    <label class="form-label" for="example-textarea">@lang('landing.message')</label>
                                    <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                                </div>

                                <button class="btn btn-primary" type="button" onclick="messageSend()">@lang('landing.send')</button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- activate app search icon (mobile) --> 
        <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
                <i class="fal fa-bell"></i>
                <span class="badge badge-icon">11</span>
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
                    <h4 class="m-0 text-center color-white">                       
                        <small class="mb-0 opacity-80">Voucher & Notification</small>
                    </h4>
                </div>
                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-messages" data-i18n="drpdwn.messages">Voucher</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-feeds" data-i18n="drpdwn.feeds">Bill Voucher</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-events" data-i18n="drpdwn.events">Notification</a>
                    </li>
                </ul>
                <div class="tab-content tab-notification">
                    <div class="tab-pane active p-3 text-center">
                        <h5 class="mt-4 pt-4 fw-500">
                            <span class="d-block fa-3x pb-4 text-muted">
                                <i class="ni ni-arrow-up text-gradient opacity-70"></i>
                            </span> Select a tab above to activate
                            <small class="mt-3 fs-b fw-400 text-muted">
                                This blank page message helps protect your privacy, or you can show the first message here automatically through
                                <a href="#">settings page</a>
                            </small>
                        </h5>
                    </div>
                    <div class="tab-pane" id="tab-messages" role="tabpanel">
                        <div class="custom-scroll h-100">
                            <ul class="notification">

                                @php
                                $all_voucher=  DB::table('shop_refill_voucher')->where('shop_id', Auth::user()->shop_id )->orderBy('id', 'Desc')->get();
                                @endphp

                                @foreach($all_voucher as $voucher)  
                                    <li>
                                        <a href="{{ asset('public/'.$voucher->store_location) }}" download class="d-flex align-items-center">
                                            <span class="status mr-2">
                                                <span class="profile-image rounded-circle d-inline-block" style="background-image:url('https://freeiconshop.com/wp-content/uploads/edd/download-flat.png'); background-size:cover"></span>
                                            </span>
                                            <span class="d-flex flex-column flex-1 ml-1">
                                                <span class="name">Rack-Socks Voucher</span>
                                                <span class="msg-a fs-sm">{{ $voucher->voucher_name }}</span>
                                                <span class="fs-nano text-muted mt-1">{{ date('jS F,Y h:i a', strtotime($voucher->entry_datetime)) }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach


                                
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-feeds" role="tabpanel">
                        <div class="custom-scroll h-100">
                            <ul class="notification">

                                @php
                                $all_voucher=  DB::table('shock_bills')->where('shop_id', Auth::user()->shop_id )->orderBy('id', 'Desc')->get();
                                @endphp
        
                                @foreach($all_voucher as $voucher)
                                    <li>
                                        <a href="{{ asset('public/'.$voucher->voucher_link) }}" download class="d-flex align-items-center">
                                            <span class="status mr-2">
                                                <span class="profile-image rounded-circle d-inline-block" style="background-image:url('https://freeiconshop.com/wp-content/uploads/edd/download-flat.png'); background-size:cover"></span>
                                            </span>
                                            <span class="d-flex flex-column flex-1 ml-1">
                                                <span class="name">Rack-Socks Voucher</span>
                                                <span class="msg-a fs-sm"> {{ $voucher->shocks_bill_no }}</span>
                                                <span class="fs-nano text-muted mt-1">{{ date('jS F,Y h:i a', strtotime($voucher->entry_datetime)) }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
        

                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-events" role="tabpanel">
                        <div class="d-flex flex-column h-100">
                            <div class="flex-1 custom-scroll">
                                <div class="p-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    <!-- app user menu -->
       <div>
           <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com" class="header-icon d-flex align-items-center justify-content-center ml-2">
               @if(!empty(Auth::user()->image))
                    <img src="{{ asset('uploads/user_image')}}/<?php echo Auth::user()->image; ?>" class="profile-image rounded-circle" alt="">
                @else
                    <img src="{{ asset('public/backend/assets/img/avatar.png') }}" class="profile-image rounded-circle" alt="">
                @endif
               <!-- you can also add username next to the avatar with the codes below:
               <span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
               <i class="ni ni-chevron-down hidden-xs-down"></i> -->
           </a>
           <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
               <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                   <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                       <span class="mr-2">
                            @if(!empty(Auth::user()->image))
                                <img src="{{ asset('uploads/user_image')}}/<?php echo Auth::user()->image; ?>" class="rounded-circle profile-image" alt="">
                            @else
                                <img src="{{ asset('public/backend/assets/img/avatar.png') }}" class="rounded-circle profile-image" alt="">
                            @endif
                           
                       </span>
                       <div class="info-card-text">
                           <div class="fs-lg text-truncate text-truncate-lg">{{ Auth::user()->name }} &nbsp;[<?php 
                           $role_id = Auth::user()->role_id;
                           $get_role = DB::table('roles')->where('id', $role_id)->first();
                            echo $get_role->name;
                           ?>]</div>
                           <span class="text-truncate text-truncate-md opacity-80">{{ Auth::user()->mobile_number }}</span>
                            
                        </div>

                     

                   </div>
               </div>
            
              
               
           <div class="dropdown-divider m-0"></div>
            
                <div class="row">

                    <div class="col-md-12" style="">
                        <a href="{{ url('user-profile') }}" class="dropdown-item fw-500 pt-3 pb-3" style="color:black;border-bottom: 1px solid #7c7c7c59;" href="{{ route('password.change') }}">                   
                        <i class="fas fa-user"></i> <span>&nbsp; My Profile</span>
                        </a>
                        
                    </div>

                    <div class="col-md-12" style="">
                        <a class="dropdown-item fw-500 pt-3 pb-3" style="color:black;border-bottom: 1px solid #7c7c7c59;" href="{{ route('password.change') }}" href="{{ route('password.change') }}">                   
                        <i class="fas fa-lock" aria-hidden="true"></i> <span>&nbsp; PIN Change</span>
                        </a>
                        
                    </div> 

                    <div class="col-md-12">
                        <a class="dropdown-item fw-500 pt-3 pb-3" ref="{{ route('logout') }}"  onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">                   
                            <i class="fas fa-sign-out-alt"></i> <span data-i18n="drpdwn.page-logout">&nbsp; Logout</span>
                        </a>
                    </div>
                        
                             
                </div>
                    
             

           </div>
       </div>
   </div>
</header>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
  @csrf
</form>

<!-- END Page Header -->
