
@if(count($parent_menus) > 0)
@foreach($parent_menus as $single_parent_menus)
 
 <li>
    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
        <i class="fa fa-file" aria-hidden="true"></i>
        <span class="nav-link-text" data-i18n="nav.theme_settings"> {{ $single_parent_menus->menu_name }}</span>
    </a>

    @if(count($child_menus) > 0)
    <ul>
        @foreach($child_menus as $single_child_menus)
        @if($single_parent_menus->id == $single_child_menus->parent_id)
        <li>
            @if($single_child_menus->route =='#' ) <!-- child menu has sub menu -->
            <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                <i class="fa fa-file" aria-hidden="true"></i>
                <span class="nav-link-text" data-i18n="nav.theme_settings">{{ $single_child_menus->menu_name }}</span>
            </a>
            @if(count($sub_menus) > 0)
            <ul>
                @foreach($sub_menus as $single_sub_menus)

                @if($single_child_menus->id == $single_sub_menus->parent_id)
                <li>
                    @if($single_child_menus->route =='#' ) <!-- child menu has sub child menu -->
                    <a href="{{ route('report.product') }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp;  {{ $single_sub_menus->menu_name }} </span>
                    </a>
                    @else <!-- child menu has no sub child menu -->
                    <a href="{{ route($single_child_menus->route) }}" title="Analytics Dashboard"
                        data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                                class="fal fa-dot-circle"></i> &nbsp; {{ $single_child_menus->menu_name }}</span>
                    </a>

                    @endif <!-- child menu has sub child menu -->
                </li>
                @endif
                @endforeach
            </ul>
            @endif
        
          @else <!-- child menu has no sub menu -->
          <a href="{{ route($single_child_menus->route) }}" title="Analytics Dashboard"
                data-filter-tags="application intel analytics dashboard">
                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options"><i
                        class="fal fa-dot-circle"></i> &nbsp; {{ $single_child_menus->menu_name }}</span>
            </a>
          @endif <!-- child menu has sub menu -->
        </li>
        @else
        
        @endif
        @endforeach

    </ul>
    @endif
  </li>

  @endforeach
  @endif



    
    
