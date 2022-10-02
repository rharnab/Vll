<!-- <style>
    .nav-menu li a:hover{
       
        color: white !important;
    }
    .nav-menu li > ul li a{
        color: white !important;
    }
</style>
 -->

<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-cog" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Parameter Setup</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('parameter_setup.agent.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Agent User</span>
            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.brand.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Brand</span>
            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.brandsize.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Brand Sizes</span>
            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.racks.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Racks</span>
            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.shops.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Shops</span>
            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.product_categories.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Product Categories</span>
            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.types.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Types </span>
            </a>
        </li>

        <li>
            <a href="{{ route('parameter_setup.products.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">

                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Procuct </span>

            </a>
        </li>


        <li>
            <a href="{{ route('parameter_setup.user.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Create User </span>
            </a>
        </li>

        <li>
            <a href="{{ route('parameter_setup.commission.create') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Commission Set Up </span>
            </a>
        </li>


    </ul>
</li>

<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-socks" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Stock</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('stock.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Product Stock</span>
            </a>
        </li>
    </ul>
</li>


<li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-tasks" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Racks Fillup</span>
    </a>
    <ul>
        <li>
            <a href="{{ route('rack.rack-fillup.index') }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; Socks Rack Fillup</span>
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
    <a href="{{ route('bill.rack.bill_voucher.voucher_list') }}" title="Analytics Dashboard"
        data-filter-tags="application intel analytics dashboard">
        <i class="fa fa-file-invoice" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Rack Bill Voucher</span>
    </a>
</li>



  <li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
    <i class="fas fa-money-bill-alt"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings">Accounts</span>
    </a>

    <ul>

    <li> 
        <a href="#" title="Theme Settings" data-filter-tags="theme settings">
            <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Transaction</span>
        </a>

        <ul>
            <li>
                <a href="{{ route('account.transaction.create') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"> <i class="fas fa-money-bill-alt"></i> &nbsp; Create Transaction  </span>
            </a>
            </li>

            <li>
                <a href="{{ route('account.transaction.auth') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"> <i class="fas fa-money-bill-alt"></i> &nbsp; Auth transaction  </span>
            </a>
            </li>
        </ul>
    <li>

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
                
            </ul>
        </li>

        <li>
            <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Account Report</span>
            </a>

            <ul>
                <li>
                    <a href="{{ route('account.report.transfer.index') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"> <i
                                class="fas fa-money-bill-alt"></i> &nbsp; Transfer Report </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('account.report.gl.balance') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"> <i
                                class="fas fa-money-bill-alt"></i> &nbsp; GL Balance </span>
                    </a>
                </li>

                <!-- <li>
                <a href="{{ route('account.report.gl.balance_2') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"> <i class="fas fa-money-bill-alt"></i> &nbsp; Sample 2  </span>
                </a>
            </li> -->

                <!-- <li>
                <a href="{{ route('account.report.gl.pdf') }}" title="Analytics Dashboard" data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"> <i class="fas fa-money-bill-alt"></i> &nbsp; PDF Download  </span>
                </a>
            </li> -->

            </ul>
        <li>

        <li>
            <a href="{{route('report.billdue.index')}}" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">Bill Due Report</span>
            </a>

        </li>

    </ul>
  </li>
  
  
<li> 
    <a href="{{url('db-backup')}}" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-download" aria-hidden="true"></i>
            <span class="nav-link-text" data-i18n="nav.theme_settings">Download Database</span>
    </a>

<li>
  