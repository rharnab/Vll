

<!-- <li>
    <a href="{{ route('agent.rack.bill_collection.rack_list') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
    <i class="fas fa-money-bill"></i>
        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Bill Collection</span>
    </a>
 </li> -->


 <li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-cog" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Bill Collection</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('bill.collection.racklist') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp;All Due Collection</span>
            </a>
        </li>

        <li>
            <a href="{{ route('bill.collection.allRack') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp;Monthly Bill Collection</span>
            </a>
        </li>

    </ul>
</li>


<li>
    <a href="{{ route('agent.rack.bill_voucher.voucher_list') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
        <i class="far fa-sticky-note"></i>
        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Voucher</span>
    </a>
 </li>

 
 <li>
    <a href="{{ route('agent.sold_delete.rack_list') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
        <i class="far fa-trash-alt"></i>
        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Wrong Sold</span>
    </a>
 </li>

<li>
    <a href="{{route('report.billdue.index')}}" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Bill Due Report</span>
    </a>

</li>

<li> 
    <a href="{{url('dashboard/index')}}" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-cog" aria-hidden="true"></i>
            <span class="nav-link-text" data-i18n="nav.theme_settings">Master Dahsboard</span>
    </a>
<li>
  
<li>
    <a href="{{route('report.shop_visit')}}" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Shop Visit Report</span>
    </a>        
</li>

<li>
 <li>
    <a href="{{ route('report.socks_return_report.index') }}" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Socks Return Report</span>
    </a>        
</li>

  <li>
    <a href="{{ route('report.agent.commission.index') }}" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Agent Commission</span>
    </a>        
</li>

<li>
        <a href="{{ route('report.dashboard.over_view') }}" title="Analytics Dashboard"
            data-filter-tags="application intel analytics dashboard">
            <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                    class="fal fa-dot-circle"></i> &nbsp; Overview Dashboard  </span>
        </a>
    </li>
 
