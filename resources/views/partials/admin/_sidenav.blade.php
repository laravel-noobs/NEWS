<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong>
                             </span> <span class="text-muted text-xs block">{{ Auth::user()->role->label     }} <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeIn m-t-xs">
                        <li><a href="{{ URL::action('Auth\AuthController@getLogout', ['ref' => 'admin']) }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    {{ $acronym }}
                </div>
            </li>
            @foreach($menu_items as $key => $val)
                @include('partials.admin._sidenav_item', $val)
            @endforeach
        </ul>

    </div>
</nav>