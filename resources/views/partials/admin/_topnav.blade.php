<div class="row border-bottom">
    <nav class="navbar navbar-static-top {{ $has_page_heading ? '' : 'white-bg' }}" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            @if($authenticated)
            <li><a> {{ $user_email }} </a></li>
            <li><a href="{{ URL::action('Auth\AuthController@getLogout') }}"><i class="fa fa-sign-out"></i> Log out</a></li>
            @endif
        </ul>

    </nav>
</div>