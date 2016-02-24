    <!--=== Header v8 ===-->
    <div class="header-v8 header-sticky">
        <!-- Topbar blog -->
        <div class="blog-topbar">
            <div class="topbar-search-block">
                <div class="container">
                    <form action="">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="search-close"><i class="icon-close"></i></div>
                    </form>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-xs-8">
                        <div class="topbar-time">Friday, Mar 13th 2015</div>
                        <div class="topbar-toggler"><span class="fa fa-angle-down"></span></div>
                        <ul class="topbar-list topbar-menu">
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Forums</a></li>
                            <li>
                                <a href="javascript:void(0);">Dropdown</a>
                                <ul class="topbar-dropdown">
                                    <li><a href="#">Dropdown</a></li>
                                    <li><a href="#">Dropdown</a></li>
                                    <li class="topbar-submenu">
                                        <a href="javascript:void(0);">Submenu</a>
                                        <ul class="topbar-submenu-in">
                                            <li><a href="#">Submenu</a></li>
                                            <li><a href="#">Submenu</a></li>
                                            <li class="topbar-submenu">
                                                <a href="javascript:void(0);">Submenu</a>
                                                <ul class="topbar-submenu-in">
                                                    <li><a href="#">Submenu</a></li>
                                                    <li><a href="#">Submenu</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="cd-log_reg hidden-sm hidden-md hidden-lg"><strong><a class="cd-signin" href="javascript:void(0);">Login</a></strong></li>
                            <li class="cd-log_reg hidden-sm hidden-md hidden-lg"><strong><a class="cd-signup" href="javascript:void(0);">Register</a></strong></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 col-xs-4 clearfix">
                        <i class="fa fa-search search-btn pull-right"></i>
                        <ul class="topbar-list topbar-log_reg pull-right visible-sm-block visible-md-block visible-lg-block">
                            @if(Auth::user()!= null)
                                <li class="home"><a> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} </a></li>
                                <li><a href="{{ URL::action('Auth\AuthController@getLogout', ['redirect' => 'https://google.com.vn']) }}"><i class="fa fa-sign-out"></i> Log out</a></li>
                            @else
                                <li class="cd-log_reg home"><a class="cd-signin" href="javascript:void(0);">Login</a></li>
                                <li class="cd-log_reg"><a class="cd-signup" href="javascript:void(0);">Register</a></li>
                            @endif
                        </ul>
                    </div>
                </div><!--/end row-->
            </div><!--/end container-->
        </div>
        <!-- End Topbar blog -->
        @include('unify.partials._navbar')
    </div>
    <!--=== End Header v8 ===-->