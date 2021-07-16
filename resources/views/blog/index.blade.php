<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>

    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="وب سازنده">
    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')"/>


    @yield('ogtag')
    <meta property="og:title" content="@yield('title') {{$response['app_name']}}" />
    <meta property="og:description" content="@yield('description')"/>
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:site_name" content="{{$response['app_name']}}" />

    <link rel="canonical" href="@yield('canonical')">

    <title>@yield('title')  - {{$response['app_name']}} </title>
    <link rel="shortcut icon" href="{{url((isset($response['app_logo']) ? $response['app_logo'] : 'front/img/structure/websazandeh.png'))}}" type="image/x-icon" />


    <link rel="stylesheet" href="{{url('/front/css/app10.css?v=5')}}">
    <link rel="stylesheet" href="{{url('/front/css/fontawesome/css/all.min.css ')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body id="page-top " class="main-bg">


<!-- *************      MENU        ******************  -->
@include('blog.top.header')
<!-- *************      MENU        ******************  -->

@yield('breadcrumb')

@yield('content')




<!-- *************      FOOTER      ******************  -->
@include('blog.down.footer')
<!-- *************      FOOTER      ******************  -->

<!-- *************      SCRIPT      ******************  -->
<script src="{{url('/front/js/app10.js?v=5')}}"></script>
<!-- *************      SCRIPT      ******************  -->

@yield('script')

<script>
    const openMenu = () => {
        document.getElementById('mobileMenu').classList.toggle('open');
    };

    const openSearchMobile= () => {
        document.getElementById('mobileSearch').classList.toggle('open');
    };
    // show and hide serachox
    $(document).mouseup(function(e){
        var container = $("#search_div");

        // If the target of the click isn't the container
        if(!container.is(e.target) && container.has(e.target).length === 0){
            $('#search_box_id').hide('slow');
        }
    });
    function show_search_form() {
        $('#search_box_id').fadeToggle('slow');
    }

</script>

</body>
</html>
