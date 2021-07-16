@extends('front.index')

@section('title','درباره ما')
@section('description','    املاک اصفهان به جستجوی آسان برای فروش ملک برای فروش یا اجاره و می پردازد. از ویژگی نقشه برای موقعیت مکانی منحصر به فرد خود برای پیدا کردن ویلای ایده آل، خانه شهری یا آپارتمان استفاده کنید و با صاحبان اصلی تماس بگیرید. ما فقط چند ثانیه به شما کمک خواهیم کرد خانه رویایی خود را پیدا کنیم. .ما مشتریان خود را با تمام جنبه های خرید و فروش خانه به مشتریان خود ارائه می دهیم. این سایت به شما کمک می کند تا خانه رویایی خود را جستجو کنید، بحث در مورد تحولات جدید املاک و یا کمک به فروش اموال شما، ما این فرصت را برای کمک را دوست داریم. لطفا برای سؤالات خود با ما تماس بگیرید!')

@section('keywords','    فروش اپارتمان در اصفهان - اجاره اپارتمان در اصفهان - فروش خانه ویلایی در اصفهان - اجاره خانه ویلایی در اصفهان - فروش باغ در اصفهان - اجاره خانه مبله در اصفهان')

@section('content')

    <section class="mt-5">
        <!-- MAIN CODE -->
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="my-3 font-size-20 font-yekan font-weight-bold text-divar">{{$response['app_name']}}</h2>

                    <div>
                        {!! $response['app_description'] !!}
                    </div>


                    <div class="mb-5">
                        <div class="font-yekan font-size-17 text-divar font-weight-bold border-bottom pb-3">تلفن تماس و آدرس ما : </div>
                        <div class="font-yekan font-size-15 text-black font-weight-bold my-3">
                            <i class="fa fa-home text-divar font-size-20"></i>
                            {{$response['app_address']}}
                        </div>
                        <div>
                            <i class="fa fa-mobile text-divar font-size-20"></i>
                            @foreach(explode('-',$response['app_tell']) as $tell)
                                <a href="tel:{{$tell}}" class="text-decoration-none fa-num font-size-15 text-black my-3 border-left px-2">{{$tell}}</a>
                            @endforeach

                        </div>


                    </div>

                    <div class="my-5">
                        <div class="font-yekan font-size-17 text-divar font-weight-bold border-bottom pb-3">ما را در شبکه های اجتماعی دنبال کنید</div>

                        <div class="mt-3">
                            @foreach($response['socials'] as $social)
                                @switch($social->unique)
                                    @case ('instagram')
                                    <li class="list-inline-item ">
                                        <a class="footer-item" data-toggle="tooltip" title="کانال اینستگرام"
                                           data-placement="bottom"
                                           href="https://www.instagram.com/{{$social->value}}">
                                            <i class="fab fa-instagram text-danger fa-2x"></i>
                                        </a>
                                    </li>
                                    @break
                                    @case ('telegram')
                                    <li class="list-inline-item ">
                                        <a class="footer-item" data-toggle="tooltip" title="کانال تلگرام"
                                           data-placement="bottom"
                                           href="https://www.t.me/{{$social->value}}">
                                            <i class="fab fa-telegram text-primary fa-2x"></i>
                                        </a>
                                    </li>
                                    @break
                                    @case ('whatsapp')
                                    <li class="list-inline-item ">
                                        <a class="footer-item" data-toggle="tooltip" title="کانال وتس اپ"
                                           data-placement="bottom"
                                           href="https://www.whatsapp.com/{{$social->value}}">
                                            <i class="fab fa-whatsapp text-success"></i>
                                        </a>
                                    </li>
                                    @break
                                @endswitch

                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
