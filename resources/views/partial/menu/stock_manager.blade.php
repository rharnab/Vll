<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-cog" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Parameter Setup</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('parameter_setup.company.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Company Setup</span>
            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.category.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Category Setup</span>
            </a>
        </li>
        
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

        {{-------------------------- thsirt stock -----------------------------------------------}}
        <li>
            <a href="{{ route('stock.tshirt.create') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; T-Shirt Stock</span>
            </a>
        </li>
        {{-------------------------- thsirt stock -----------------------------------------------}}
        

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
     
      <li>
            <a href="{{ route('rack.transfer.create') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Rack Transfer</span>
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
    <a href="{{ route('bill.rack.bill_voucher.auth_voucher_list') }}" title="Analytics Dashboard"
        data-filter-tags="application intel analytics dashboard">
        <i class="fa fa-file-invoice" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Auth Rack Bill Voucher</span>
    </a>
</li>


<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Direct Sale</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('direct_sale.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Single Sale</span>
            </a>
        </li>
        <li>
            <a href="{{ route('direct_sale.auth_decline.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Sale Auth/Decline</span>
            </a>
        </li>
        <li>
            <a href="{{ route('direct_sale.report.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Direct Sale Report</span>
            </a>
        </li>

    </ul>
</li>


<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Direct Sale</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('direct_sale.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Single Sale</span>
            </a>
        </li>
        <li>
            <a href="{{ route('direct_sale.auth_decline.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Sale Auth/Decline</span>
            </a>
        </li>
        <li>
            <a href="{{ route('direct_sale.report.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Direct Sale Report</span>
            </a>
        </li>

    </ul>
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
            <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Parameter Report</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('report.product') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Product Report</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('report.commission.index') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Commission report </span>
                    </a>
                </li>
            </ul>
        </li>


        <li>
            <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Stock Report</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Lot Summary</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('report.lot_brands') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Lot Brands</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Lot Packets</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Individual Paket Socks</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('report.lot.summary') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Individual Rack Socks</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('report.socks_code_generate') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Socks Code Generate</span>
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
                    <a href="{{ route('report.packet_code_generate') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Packet Code Generate</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('report.rack_refil_voucher') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Rack Refil Voucher</span>
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
                    <a href="{{ route('report.rackfill.index') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Rack Fill Up </span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('report.Rack-product.index') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Rack Product </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('report.shop.voucher.index') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Shop Voucher  </span>
                    </a>
                </li>
                
                 <li>
                    <a href="{{ route('report.Rack.product.index') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; Rack Product Voucher  </span>
                    </a>
                </li>
                
            </ul>
        </li>

        

        <li>
            <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Bill Report</span>
            </a>

            <ul>

                <li>
                    <a href="{{route('report.billdue.index')}}" title="Theme Settings" data-filter-tags="theme settings">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <span class="nav-link-text" data-i18n="nav.theme_settings">Bill Due Report</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('report.bill_authorize_report')}}" title="Theme Settings" data-filter-tags="theme settings">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <span class="nav-link-text" data-i18n="nav.theme_settings">Bill Authorize Report</span>
                    </a>
                </li>

            </ul>

        </li>


        <li>
            <a href="{{route('report.socks_log_report')}}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Socks Log History Report</span>
            </a>        
        </li>
        
         <li>
            <a href="{{route('report.status_wise_report')}}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Status Wise Report</span>
            </a>        
        </li>
        
        <li>
            <a href="{{route('report.shop_visit')}}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Shop Visit Report</span>
            </a>        
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
            <a href="{{route('report.status_wise_report')}}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Shop Status Wise Report</span>
            </a>        
        </li>


        <li>
            <a href="{{ route('report.agent.shop-tag') }}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Agent Shop Tag</span>
            </a>        
        </li>
        
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

        {{-- ############################## End cahs Report ############################### --}}

 

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

