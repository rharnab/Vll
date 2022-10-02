<nav id="js-primary-nav" class="primary-nav" role="navigation">
    <div class="nav-filter">
       <div class="position-relative">
          <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
          
       </div>
    </div>
    
    <ul id="js-nav-menu" class="nav-menu">
         <li class="{{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ route('home') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
                <i class="fa fa-home"></i>
                <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Dashboard</span>
            </a>
         </li>


         {{-- @include('partial.menu.menus_list')  --}}
        
         
            <!-- super admin menu list --> 
            @if(Auth::user()->role_id == 1)
                @include('partial.menu.super_admin')
            @endif
             <!-- Agent Menu List  -->
            @if(Auth::user()->role_id == 2)
                @include('partial.menu.agent')
            @endif

           <!--  Stock Manager menu list --> 
            @if(Auth::user()->role_id == 3)
                @include('partial.menu.stock_manager')
            @endif

            <!-- Account Manager menu list --> 
            @if(Auth::user()->role_id == 4)
            @include('partial.menu.product_user')
            @endif

         <!-- Finance Manager menu list  -->
            @if(Auth::user()->role_id == 5)
            @include('partial.menu.finance_manager')
            @endif
            
        
             <!-- All Agent menu list  -->
         @if(Auth::user()->role_id == 8)
            @include('partial.menu.all_agent')
            @endif
         
    </ul>
    <div class="filter-message js-filter-message bg-success-600"></div>
 </nav>