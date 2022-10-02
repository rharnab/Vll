<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-cog" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Parameter Setup</span>
    </a>
    <ul>
        <li>
           <a href="{{ route('parameter_setup.agent.index') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">               
               <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Agent User</span>
           </a>
        </li>


        <li>          
           <a href="{{ route('parameter_setup.racks.index') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">               
               <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Racks</span>
           </a>
        </li>


        <li>          
           <a href="{{ route('parameter_setup.shops.index') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">               
               <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Shops</span>
           </a>
        </li>

         <li>
            <a href="{{ route('parameter_setup.products.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">

                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Procuct </span>

            </a>
        </li>

       
    </ul>
</li>


<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Stock</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('stock.index') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
               <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp;  Product Stock</span>
           </a>
        </li>


        <!-- <li>
            <a href="{{ route('stock.lot_voucher') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
               <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp;  Lot Voucher</span>
           </a>
        </li> -->

    </ul>
</li>



<li>
  <a href="#" title="Theme Settings" data-filter-tags="theme settings">
    <i class="fa fa-tasks" aria-hidden="true"></i>
      <span class="nav-link-text" data-i18n="nav.theme_settings">Racks Fillup</span>
  </a>
  <ul>
      <li>
         <a href="{{ route('rack.rack-fillup.index') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
             <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Socks Rack Fillup</span>
         </a>
      </li>
      <li>
            <a href="{{ route('rack.mapping.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Rack Mapping</span>
            </a>
        </li>
        
  </ul>
</li>


<li>
    <a href="{{ route('bill.rack.bill_voucher.voucher_list') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
        <i class="fa fa-file-invoice" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Rack Bill Voucher</span>
    </a>
 </li>


<li>
        <a href="#" title="Theme Settings" data-filter-tags="theme settings">
            <i class="fal fa-exchange-alt" aria-hidden="true"></i>
            <span class="nav-link-text" data-i18n="nav.theme_settings">Product Status Change</span>
        </a>
        <ul>
            <li>
                <a href="{{ route('agent.rack.product_status_change.index') }}" title="Analytics Dashboard"
                    data-filter-tags="application intel analytics dashboard">
                    <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                            class="fal fa-dot-circle"></i> &nbsp; Status Change </span>
                </a>
            </li>

            <li>
                <a href="{{ route('rack.socks_return.index') }}" title="Analytics Dashboard"
                    data-filter-tags="application intel analytics dashboard">
                    <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                            class="fal fa-dot-circle"></i> &nbsp; Rack Socks Return</span>
                </a>
            </li>


             <li>
                <a href="{{ route('rack.socks_return.socks_return_voucher') }}" title="Analytics Dashboard"
                    data-filter-tags="application intel analytics dashboard">
                    <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                            class="fal fa-dot-circle"></i> &nbsp; Socks Return Voucher</span>
                </a>
            </li>

        </ul>
    </li>
    

<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Report</span>
    </a>
    <ul>
        <li>
           <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
               <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Lot Summary</span>
           </a>
        </li>
        <li>
            <a href="{{ route('report.lot_brands') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Lot Brands</span>
            </a>
        </li>
        <li>
            <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Lot Packets</span>
            </a>
        </li>
        <li>
            <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Individual Paket Socks</span>
            </a>
        </li>

         <li>
             <a href="" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                 <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Lot Summary</span>
             </a>
          </li>



        <li>
            <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Individual Rack Socks</span>
            </a>
        </li>


        <li>
            <a href="{{ route('report.socks_code_generate') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Socks Code Generate</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('report.packet_code_generate') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Packet Code Generate</span>
            </a>
        </li>


        <li>
            <a href="{{ route('report.product') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Product Report</span>
            </a>
        </li>
        
          <li>
            <a href="{{ route('report.Rack-product.index') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">             
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i class="fal fa-dot-circle"></i> &nbsp; Rack Product</span>
            </a>
        </li>

         <li>
            <a href="{{ route('report.stock.summary') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Stock Summary </span>
            </a>
        </li>


        <li>
            <a href="{{ route('report.shop.voucher.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Rack Refill Voucher  </span>
            </a>
        </li>

        <li>
            <a href="{{route('report.billdue.index')}}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Bill Due Report</span>
            </a>


        <li>
            <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Rack Report</span>
            </a>

            <ul>
                <li>

                    <a href="{{ route('report.socks_code_generate') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp;Rack Socks Code Generate</span>
                    </a>

                </li>
                
                
                 <li>
                    <a href="{{ route('report.socks_code_generate2') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Socks Code Generate with Date</span>
                    </a>
                </li>
                

                <li>
                   <a href="{{ route('report.shop.voucher.index') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Rack Refil Voucher  </span>
                    </a>
                </li>


                <li>
                   <a href="{{ route('report.rack.currentsocks') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Rack Current Socks </span>
                    </a>
                </li>


            </ul>
        </li>
        
         {{-- ############################## cahs Report ############################### --}}
        <li>
            <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Cash Report</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('report.cash_report.lot') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp;Lot Report</span>
                    </a>
                </li>
            </ul>
        </li>


        <li>
            <a href="{{ route('report.agent.shop-tag') }}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Agent Shop Tag</span>
            </a>        
        </li>

        {{-- ############################## End cahs Report ############################### --}}


    </ul>

    
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

