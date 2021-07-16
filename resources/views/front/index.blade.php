<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="">

    <title> {{$response['app_name']}} - @yield('title') </title>
    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')"/>
    <link rel="icon"  type="image/jpg" sizes="96x96" href="{{url($response['app_logo'])}}">

    <link rel="stylesheet" href="{{url('/front/css/app10.css?v=6')}}">
    <link rel="stylesheet" href="{{url('/front/css/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<!-- *************      MENU        ******************  -->
@include('front.top.navbar')
<!-- *************      MENU        ******************  -->

@yield('breadcrumb')

@yield('content')


<!-- *************      FOOTER      ******************  -->
{{--@include('front.down.footer')--}}
<!-- *************      FOOTER      ******************  -->

<!-- *************      SCRIPT      ******************  -->
<script src="{{url('/front/js/app10.js?v=6')}}"></script>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

<!-- *************      SCRIPT      ******************  -->


@yield('script')



</body>
</html>
