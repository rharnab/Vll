 <!-- BEGIN Page Header -->
 <header class="page-header" role="banner">
   <!-- we need this logo when user switches to nav-function-top -->
   <div class="page-logo">
       <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
           <img src="img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">

           <span class="page-logo-text mr-1">সূরভী </span>

           <span class="page-logo-text mr-1">
               Venture Lifestyle Limited
           </span>

           <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
           <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
       </a>
   </div>

   <!-- DOC: nav menu layout change shortcut -->
   <div class="hidden-md-down dropdown-icon-menu position-relative">
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
   </div>
   <!-- DOC: mobile button appears during mobile width -->
   
   <div class="hidden-lg-up">
       <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
           <i class="ni ni-menu"></i>
       </a>
   </div>
   <div class="search">
       <form class="app-forms hidden-xs-down" role="search" style="text-align: center;" action="page_search.html" autocomplete="off">
           <label for="" style="text-transform: uppercase;text-align:center;"> <b>{{ Auth::user()->name }} </b> </label>
       </form>
   </div>
   <div class="ml-auto d-flex">
      <!-- activate app search icon (mobile) -->
      <div class="hidden-sm-up">
        <!-- app message -->
        <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-messenger">
          
        </a>
        <!-- app notification -->
    </div>
    <!-- app settings -->
    <div class="hidden-md-down">
        <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-settings">
           
        </a>
    </div>
    <!-- app shortcuts -->
       <!-- app settings -->
       <div class="hidden-md-down">
          <a href="#" class="header-icon" style="text-transform: uppercase">
              <b> {{ Auth::user()->name }}</b>
           </a> 
       </div>
       <!-- app shortcuts -->
       <div>
           
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
