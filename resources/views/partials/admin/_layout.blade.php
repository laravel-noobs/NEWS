<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.admin._pagemeta')
    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/plugins.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
    @yield('header-style')
    @yield('header-script')
</head>

<body>

<div id="wrapper">
    @include('partials.admin._sidenav')
    <div id="page-wrapper" class="gray-bg">
        @include('partials.admin._topnav')
        @include('partials.admin._breadcrumb')
        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')
        </div>
        @include('partials.admin._footer')
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{URL::asset('js/core.js')}}"></script>
<script src="{{URL::asset('js/plugins.js')}}"></script>

<script>
    var flash_messages = JSON.parse('{!! \Flash::encode() !!}');
</script>

<!-- Custom and plugin javascript -->
<script src="{{URL::asset('js/app.js')}}"></script>
@yield('footer-script')
</body>
</html>
