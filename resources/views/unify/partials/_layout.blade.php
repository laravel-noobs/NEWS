<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>Unify - Responsive Website Template</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Web Fonts -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700'>

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="unify/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="unify/css/blog.style.css">
    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
    <!-- CSS Header and Footer -->
    <link rel="stylesheet" href="unify/css/headers/header-v8.css">
    <link rel="stylesheet" href="unify/css/footers/footer-v8.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="unify/plugins/animate.css">
    <link rel="stylesheet" href="unify/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="unify/plugins/fancybox/source/jquery.fancybox.css">
    <link rel="stylesheet" href="unify/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="unify/plugins/login-signup-modal-window/css/style.css">
    <link rel="stylesheet" href="unify/plugins/owl-carousel/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="unify/plugins/master-slider/masterslider/style/masterslider.css">
    <link rel="stylesheet" href="unify/plugins/master-slider/masterslider/skins/default/style.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="unify/css/theme-colors/default.css" id="style_color">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="unify/css/custom.css">
    <!-- CSS Customization -->
    <link rel="stylesheet" href="unify/css/custom.css">
</head>

<body class="header-fixed header-fixed-space-v2">
<div class="wrapper">
    @include('unify.partials._header')
    @yield('content')
    @include('unify.partials._footer')
    @include('unify.partials._auth')
<!-- JS Global Compulsory -->
<script src="{{URL::asset('js/core.js')}}"></script>
<script src="unify/plugins/jquery/jquery-migrate.min.js"></script>
<!-- JS Implementing Plugins -->
<script src="unify/plugins/back-to-top.js"></script>
<script src="unify/plugins/smoothScroll.js"></script>
<script src="unify/plugins/counter/waypoints.min.js"></script>
<script src="unify/plugins/counter/jquery.counterup.min.js"></script>
<script src="unify/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="unify/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
<script src="unify/plugins/master-slider/masterslider/masterslider.js"></script>
<script src="unify/plugins/master-slider/masterslider/jquery.easing.min.js"></script>
<script src="unify/plugins/modernizr.js"></script>
<script src="unify/plugins/login-signup-modal-window/js/main.js"></script> <!-- Gem jQuery -->
<!-- JS Customization -->
<script src="unify/js/custom.js"></script>
<!-- JS Page Level -->
<script src="unify/js/app.js"></script>
<script src="unify/js/plugins/fancy-box.js"></script>
<script src="unify/js/plugins/owl-carousel.js"></script>
<script src="unify/js/plugins/master-slider-showcase1.js"></script>
<script>
    jQuery(document).ready(function() {
        App.init();
        App.initCounter();
        FancyBox.initFancybox();
        OwlCarousel.initOwlCarousel();
        OwlCarousel.initOwlCarousel2();
        MasterSliderShowcase1.initMasterSliderShowcase1();
    });
</script>
<!--[if lt IE 9]>
<script src="unify/plugins/respond.js"></script>
<script src="unify/plugins/html5shiv.js"></script>
<script src="unify/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->
</body>
</html>
