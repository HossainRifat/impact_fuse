@php
    $sidebar_menus = \App\Manager\UI\MenuManager::get_menus();
@endphp

<ul class="menu">
    <li class="sidebar-title">Menu</li>

    @foreach($sidebar_menus as $sidebar_menu)
        @if(isset($sidebar_menu->sub_menus) && count($sidebar_menu->sub_menus) > 0 && \App\Manager\UI\MenuManager::check_permission_sub_menu($sidebar_menu->sub_menus))
        
        <li class="sidebar-item  has-sub">
            <a href="{{!empty($sidebar_menu->route) ? route($sidebar_menu->route).$sidebar_menu->query_string : 'javascript: void(0)'}}" class='sidebar-link'>
                {!! $sidebar_menu->icon !!}
                <span>{{$sidebar_menu->name}}</span>
            </a>
            
            <ul class="submenu ">
                @foreach($sidebar_menu->sub_menus as $sub_menu)
                    @if(!empty($sub_menu->route))
                        @can($sub_menu->route)
                            <li class="submenu-item  ">
                                <a href="{{Route::has($sub_menu->route) ? route($sub_menu->route).$sub_menu->query_string : 'javascript: void(0)'}}" class="submenu-link">
                                    {!!  $sub_menu->icon !!}
                                    <span>{{$sub_menu->name}}</span>
                                </a>
                
                            </li>
                        @endcan
                    @endif
                @endforeach
            </ul>
        </li>
        @else
            @if(!empty($sidebar_menu->route))
                @can($sidebar_menu->route)
                    <li class="sidebar-item  ">
                        <a href="{{ route($sidebar_menu->route).$sidebar_menu->query_string}}" class='sidebar-link'>
                            {!! $sidebar_menu->icon !!}
                            <span>{{$sidebar_menu->name}}</span>
                        </a>
                    </li>
                @endcan
            @endif
        @endif
    @endforeach

</ul>
