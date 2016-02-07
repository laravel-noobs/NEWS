<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.admin._pagemeta')
    <link rel="stylesheet" href="{{ elixir('css/core.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/plugins.css')}}">
    <link rel="stylesheet" href="{{ elixir('css/app.css')}}">
    @yield('header-style')

    <!-- Mainly scripts -->
    <script src="{{ elixir('js/core.js') }}"></script>
    <script src="{{ elixir('js/plugins.js') }}"></script>
    <script>
        var flash_messages = JSON.parse('{!! \Flash::encode() !!}');
    </script>
    <!-- Custom and plugin javascript -->
    <script src="{{ elixir('js/app.js') }}"></script>
    @yield('header-script')
</head>

<body class="mini-navbar"> <script> navbarMinimize(); </script>
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
@yield('footer-script')
@include('_flashmessage::_script')
</body>
</html>