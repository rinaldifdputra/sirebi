<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Reservasi Bidan | SIREBI</title>
    <link rel="stylesheet" href="{{ asset('website/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/fontawsom-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/plugins/testimonial/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/plugins/testimonial/css/owl.theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('website/assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('website/custom_style.css') }}" />
</head>

<body>

    <!-- ################# Header Starts Here#######################--->
    @include('website.components.header')

    @yield('style')
    @yield('content')
    @yield('script')

    <!-- ################# Footer Starts Here#######################--->
    @include('website.components.footer')
</body>


<script src="{{ asset('website/assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('website/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('website/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('website/assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('website/assets/plugins/testimonial/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('website/assets/js/script.js') }}"></script>


</html>
