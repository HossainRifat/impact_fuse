@php
    $sidebar_menus = \App\Manager\UI\MenuManager::get_menus();
@endphp

<ul class="menu">
    <li class="sidebar-item  has-sub">
        <a href="#" class='sidebar-link'>
            <i class="fa-solid fa-user"></i>
            <span>{{Auth::user()->name}}</span>
        </a>
        <ul class="submenu ">
            <li class="submenu-item  ">
                <a href="{{route('profile.create')}}" class="submenu-link">
                    <span>Profile</span>
                </a>
            </li>
            <li class="submenu-item  ">
                <a href="{{route('change-password')}}" class="submenu-link">
                    <span>Change Password</span>
                </a>
            </li>
            <li class="submenu-item  ">
                <a href="javascript:void(0)" class="submenu-link logout fw-bold text-danger">
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-title">Menu</li>
    <li class="sidebar-item">
        <a href="{{route('dashboard')}}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @foreach($sidebar_menus as $sidebar_menu)
        @if(isset($sidebar_menu->sub_menus) && count($sidebar_menu->sub_menus) > 0 && \App\Manager\UI\MenuManager::check_permission_sub_menu($sidebar_menu->sub_menus))
        
        <li class="sidebar-item  has-sub ">
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

@push('scripts')
<script>
    $(document).ready(function(){
        $('.logout').click(function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to logout!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('logout')}}",
                        type: 'POST',
                        data: {
                            _token: "{{csrf_token()}}"
                        },
                        success: function(response){
                            if(response.status){
                                window.location.href = "{{route('login')}}";
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
