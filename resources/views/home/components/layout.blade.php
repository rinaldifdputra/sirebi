<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Sistem Informasi Janji Temu Bidan | SIREBI</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/icon_sirebi.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawsom-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/testimonial/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/testimonial/css/owl.theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />

    <style>
        * {
            list-style: none;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <!-- ################# Header Starts Here#######################--->
    @include('home.components.header')

    @yield('style')
    @yield('content')
    @yield('script')

    <!-- ################# Footer Starts Here#######################--->
    @include('home.components.footer')
</body>


<script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('assets/plugins/testimonial/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>


</html>
