<aside class="page-sidebar list-filter-active">
    <div class="page-logo">
       <a href="{{ route('home') }}" class="page-logo-link press-scale-down d-flex align-items-center position-relative" >
         <img src="{{ asset('public/backend/assets/img/logo.png') }}" alt="SmartAdmin WebApp" aria-roledescription="logo">
         <span class="page-logo-text mr-1">VSL-BANK</span>
         <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>       
       </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    @include('partial._navbar')
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
       <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
       <i class="ni ni-chevron-right"></i>
       <i class="ni ni-chevron-right"></i>
       </a>
       <ul class="list-table m-auto nav-footer-buttons">
          <li>
             <a href="javascript:void(0);" class="menu_copywrite" data-toggle="tooltip" data-placement="top" title="Support Chat">
             <i class="fal fa-copyright"></i> Venture Solution Limited
             </a>
          </li>
       </ul>
    </div>
    <!-- END NAV FOOTER -->
 </aside>