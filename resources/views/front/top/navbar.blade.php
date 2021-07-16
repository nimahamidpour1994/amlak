@php

    if (\Illuminate\Support\Facades\Cookie::get('city'))
    {
        $city=\Illuminate\Support\Facades\Cookie::get('city');

    }
    else
    {
        $city=\App\Models\City::orderBy('name','ASC')->first()->id;

    }

    $name='city';
    \Illuminate\Support\Facades\Cookie::queue($name, $city,43200);


@endphp
<nav class="navbar navbar-expand-lg navbar-style pr-0 px-1 py-1" id="main-nav">

    <a class="navbar-brand red-color bold header-style px-0 mx-xl-1 mx-0 m-xl-1 mx-lg-1" href="{{route('app.home')}}" >
        <img src="{{url('front/img/structure/logo.png')}}" style="height: 2.7rem;" />
    </a>

    <button class="border border-muted rounded font-iran font-size-14 mt-2 p-2 mx-1
                bold bg-light text-secondary shadow-none" name="City" id="City_id"
                data-toggle="modal" data-target="#choose_city">
        <i class="fa fa-map-marker-alt"></i>
        @foreach(\App\Models\City::orderBy('name','ASC')->get() as $city)
            @if(\Illuminate\Support\Facades\Cookie::get('city')==$city->id)
                {{$city->name}}
            @endif
       @endforeach
    </button>


    <div class="collapse navbar-collapse d-none d-lg-block" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item align-right">
                <a class="nav-link text-decoration-none text-black font-size-14 single-card" href="{{route('user.bookmarks')}}">پروفایل من  <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item align-right">
                <a class="nav-link text-black font-size-14  single-card" href="{{url(route('user.listenbell.add','choose-category'))}}">گوش به زنگ</a>
            </li>
            <li class="nav-item  align-right">
                <a class="nav-link text-black font-size-14  single-card" href="{{route('app.aboutus')}}">درباره ما</a>
            </li>
            <li class="nav-item  align-right">
                <a class="nav-link text-black font-size-14 single-card" href="{{url(route('app.blog','main'))}}">بلاگ</a>
            </li>
            <li class="nav-item  align-right">
                <a class="nav-link text-black font-size-14 single-card" href="{{route('app.page','rule')}}">قوانین و مقررات</a>
            </li>
            <li class="nav-item  align-right">
                <a class="nav-link text-black font-size-14 single-card" href="{{route('app.page','question')}}">سوالات متداول</a>
            </li>
            <li class="nav-item  ml-1 align-right">
                <a class="nav-link text-black font-size-14 single-card" href="{{route('app.contactus')}}">تماس با ما</a>
            </li>
            @auth
            <li class="nav-item  ml-1 align-right">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <input type="submit" class="btn nav-item ml-1 align-center font-iran font-size-14 rounded-0 single-card" value="خروج">
                </form>
            </li>

           @endauth

        </ul>
    </div>

    <a href="{{route('user.advertisment.add','choose-category')}}" class="btn bg-divar text-white btn-sm ml-1 mt-1 py-1 font-size-12  font-iran">ثبت رایگان آگهی</a>

    <div class="dropdown d-block d-lg-none">
        <button class="btn bg-white border border-muted shadow-none" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bars bold"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <ul class="navbar-nav mr-auto mt-2">
                <li class="nav-item align-right">
                    <a class="nav-link text-decoration-none text-black bold" href="{{route('user.bookmarks')}}">پروفایل من  <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item  align-right">
                    <a class="nav-link text-decoration-none text-black bold" href="{{url(route('user.listenbell.add','choose-category'))}}">گوش به زنگ</a>
                </li>

                <li class="nav-item  align-right">
                    <a class="nav-link text-black bold" href="{{route('app.aboutus')}}">درباره ما</a>
                </li>
                <li class="nav-item  align-right">
                    <a class="nav-link text-black bold" href="{{url(route('app.blog','main'))}}">بلاگ</a>
                </li>
                <li class="nav-item  align-right">
                    <a class="nav-link text-black bold" href="{{route('app.page','rule')}}">قوانین و مقررات</a>
                </li>
                <li class="nav-item  align-right">
                    <a class="nav-link text-black bold" href="{{route('app.page','question')}}">سوالات متداول</a>
                </li>
                <li class="nav-item  ml-1 align-right">
                    <a class="nav-link text-black bold" href="{{route('app.contactus')}}">تماس با ما</a>
                </li>
                @auth
                    <li class="nav-item  ml-1 align-right">
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <input type="submit" class="btn nav-item  ml-1 align-center font-iran bold" value="خروج">
                        </form>
                    </li>

                @endauth

            </ul>
        </div>
    </div>

</nav>


<div class="modal fade direction-rtl" id="choose_city" tabindex="-1" role="dialog"
     aria-hidden="true" style="direction:rtl!important;text-align:right;z-index: 50000;margin-top: 100px">
    <div class="modal-dialog" style="max-width: 600px!important;" role="document">
        <div class="modal-content">

            <div class="modal-header direction-rtl">
                <h3 class="modal-title font-size-15 text-black bold" id="exampleModalLabel">انتخاب شهر</h3>
                <button class="close text-left pl-0 ml-0" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="container my-3">

                    <div class="row">
                        @foreach(\App\Models\City::orderBy('name','ASC')->get() as $city)
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                @if(\Illuminate\Support\Facades\Cookie::get('city')==$city->id)
                                    <button class="btn btn-danger btn-block btn-sm font-yekan mx-2 rounded mb-3"
                                            onclick="changeCityModal('{{$city->id}}')">{{$city->name}}</button>
                                @else
                                    <button class="btn btn-outline-danger btn-block font-yekan mx-2 btn-sm rounded mb-3"
                                            onclick="changeCityModal('{{$city->id}}')">
                                        {{$city->name}}</button>
                                @endif
                            </div>
                        @endforeach
                    </div>




            </div>
        </div>
    </div>
</div>


<script>
    function changeCityModal(city){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'/Api/changeCity',
            method:'post',
            data:{city:city},
            success:function (data) {
                window.location.reload();
            }
        });
    }
</script>
