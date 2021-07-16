<div class="container bg-white border-top-red">

    <!-- TIME AND SOCIAL -->
    <div class="row bg-light py-2 nav-box-shadow">

        <!-- TIME-->
        <div class="col-6 text-right">
            <div>
                   <span class="mb-3 fa-num font-size-12 bold">{{jdate()->format('%A, %d %B %y')}}</span>
            </div>
        </div>

        <!-- SOCIAL MEDIA -->
        <div class="col-6 text-left">
            @foreach($response['socials'] as $social)
                @switch($social->unique)
                    @case ('instagram')
                    <li class="list-inline-item ">
                        <a class="footer-item" data-toggle="tooltip" title="کانال اینستگرام"
                           data-placement="bottom"
                           href="https://www.instagram.com/{{$social->value}}">
                            <i class="fab fa-instagram text-dark"></i>
                        </a>
                    </li>
                    @break
                    @case ('telegram')
                    <li class="list-inline-item ">
                        <a class="footer-item" data-toggle="tooltip" title="کانال تلگرام"
                           data-placement="bottom"
                           href="https://www.t.me/{{$social->value}}">
                            <i class="fab fa-telegram text-dark"></i>
                        </a>
                    </li>
                    @break
                    @case ('whatsapp')
                    <li class="list-inline-item ">
                        <a class="footer-item" data-toggle="tooltip" title="کانال وتس اپ"
                           data-placement="bottom"
                           href="https://www.whatsapp.com/{{$social->value}}">
                            <i class="fab fa-whatsapp text-dark"></i>
                        </a>
                    </li>
                    @break
                @endswitch

            @endforeach
        </div>

    </div>

    <!-- APP NAME -->
    <div class="row mb-4 d-none d-xl-block d-lg-block d-md-block">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 direction-rtl py-2 text-xl-right text-lg-right text-md-right text-center font-size-26 font-600">
            <a href="{{route('app.blog','main')}}" class="font-yekan text-decoration-none text-divar px-4 font-size-28 bold">{{ $response['app_name']}}</a>
            <div class="mt-2 d-inline-block">
                <span class="icon-classic">
                    <p class=" my-4 font-iran  bold"> بلاگـ </p>
                </span>
            </div>
        </div>
    </div>
    <!-- APP NAME -->

    <!-- MENU -->
    <div class="row">

        <!-- MENU DESKTOP -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-scrolled w-100 p-0 m-0 border-bottom-red direction-ltr bg-black  d-none d-lg-block" id="mainNav">
            <div class="container-fluid">

                <div id="search_div">
                    <button class="bg-transparent ml-4 border-none shadow-none" id="search_btn" onclick="show_search_form()">
                        <i class="fa fa-search"></i>
                    </button>

                    <div class="col-4 border-top-red bg-light p-3 search_form" style="display: none" id="search_box_id">
                        <form action="{{route('app.blog.search')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="submit" class="btn bg-black font-yekan text-white rounded-0
                                            px-3 text-center border-none" style="height: 35px!important" value="جستجو" onclick="search()">
                                <input type="text" style="height: 34px!important;"
                                       class="form-control text-right fa-num font-size-12
                                       shadow-none direction-rtl text-black" autocomplete="off"
                                        onkeyup="suggest_search_blog()" id="search_text_id" name="search_text_name">
                            </div>

                            <div class="border-top mt-3 direction-rtl text-center" id="aj_search_content">

                            </div>

                        </form>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0 direction-rtl">
                        @foreach($response['categories'] as $category)
                            <li class="nav-item align-center">
                                <a  class="nav-link js-scroll-trigger font-yekan font-size-15 font-weight-normal text-secondary my-2"
                                    href="{{route('app.blog',$category->slug)}}">
                                    {{$category->name}}
                                </a>
                            </li>
                        @endforeach
                        
                         <li class="nav-item align-center">
                                <a  class="nav-link js-scroll-trigger font-yekan font-size-15 font-weight-normal text-secondary my-2"
                                    href="{{route('app.home')}}">
                                    سایت {{$response['app_name']}}
                                </a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
        <!-- MENU DESKTOP -->

        <!-- MENU MOBILE -->
        <div class="col-12 d-block d-lg-none bg-black direction-rtl">


            <div class="d-flex justify-content-between position-relative d-md-none d-block p-1">
                <button class="menuBtn btn " onclick="openMenu()" >
                    <i class="fas fa-bars font-size-22 text-white bold"></i>
                </button>
                <div class="d-inline-block mx-auto">
                    <a href="{{route('app.blog','main')}}" class="font-yekan text-decoration-none text-divar font-size-25 bold">{{ $response['app_name']}}</a>
                    <img src="{{url('blog/img/blog.png')}}">
                </div>

                <button class="bg-transparent border-none shadow-none" id="search_btn" onclick="openSearchMobile()">
                    <i class="fa fa-search"></i>
                </button>
            </div>

            <nav class="mainNav" id="mobileMenu">
                <div class="mb-5 d-flex d-md-none w-100 justify-content-between align-items-center">
                    <a href="{{route('app.blog','main')}}" class="font-yekan text-decoration-none text-divar font-size-25 bold">{{ $response['app_name']}}</a>
                    <button class="close font-38" onclick="openMenu()">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>

                <ul class="list-unstyled bold">
                    @foreach($response['categories'] as $category)
                        <li>
                            <a  href="{{route('app.blog',$category->slug)}}" class="font-yekan font-weight-normal text-white text-decoration-none">
                                {{$category->name}}
                            </a>
                        </li>
                    @endforeach
                        <li>
                                <a  class="font-yekan font-weight-normal text-white text-decoration-none"
                                    href="{{route('app.home')}}">
                                    سایت {{$response['app_name']}}
                                </a>
                        </li>
                </ul>
            </nav>

            <div class="mainNav" id="mobileSearch">

                <div class="mb-5 d-flex d-md-none w-100 justify-content-between align-items-center">
                    <button class="close font-38" onclick="openSearchMobile()">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>

                <div class="row">
                    <div class="col-11 search_form m-0 p-0" id="search_box_id">
                        <form action="{{route('app.blog.search')}}" method="post" class="mr-2">
                            @csrf
                                <h2 class="font-size-14 text-white text-center mb-4 font-yekan">جستجو</h2>
                            <input type="text" style="height: 34px!important;"
                                   class="form-control text-right fa-num font-size-12
                                       shadow-none direction-rtl text-white border-bottom border-top-0 border-left-0 border-right-0 rounded-0 bg-black" autocomplete="off"
                                   onkeyup="suggest_search_blog_mobile()" id="search_text_mobile_id" name="search_text_name">


                            <div class="mt-3 pt-3 direction-rtl" id="aj_search_content_mobile">

                            </div>

                        </form>
                    </div>
                </div>


            </div>

        </div>
        <!-- MENU MOBILE -->

    </div>
    <!-- MENU -->
</div>

