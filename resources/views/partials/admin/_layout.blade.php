<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Main view</title>

    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
    @yield('header-style')
</head>

<body>

<div id="wrapper">
    @include('partials.admin._topnav')
    <div id="page-wrapper" class="gray-bg">
        @include('partials.admin._sidenav')
        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')
        </div>
        @include('partials.admin._footer')
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{URL::asset('js/core.js')}}"></script>
<script src="{{URL::asset('js/plugins.js')}}"></script>
<!-- Custom and plugin javascript -->
<script src="{{URL::asset('js/app.js')}}"></script>
@yield('footer-script')
</body>
</html>
