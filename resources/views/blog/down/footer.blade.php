<section class="page-section direction-ltr p-0">
    <div class="container bg-dark border-top-red">
        <div class="row mx-auto px-0 py-1">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center direction-rtl py-4">
                <a href="#" class="text-decoration-none color-red font-yekan font-size-28 font-weight-bold p-3">{{ $response['app_name']}}</a>
                <span class="mt-2">
                     <span class="icon-classic">
                        <p class="my-4 font-iran font-weight-bold"> بلاگـ </p>
                     </span>
                </span>
                <div class="row mx-auto w-75">
                    <p class="font-size-14 my-4 line-35 color-gray font-yekan">
                       {!! $response['blog_footer'] !!}
                    </p>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    @foreach($response['socials'] as $social)
                        @switch($social->unique)
                            @case ('instagram')
                            <li class="list-inline-item">
                                <a class="footer-item" data-toggle="tooltip" title="کانال اینستگرام"
                                   data-placement="bottom"
                                   href="https://www.instagram.com/{{$social->value}}">
                                    <i class="fab fa-instagram text-white fa-2x"></i>
                                </a>
                            </li>
                            @break
                            @case ('telegram')
                            <li class="list-inline-item ">
                                <a class="footer-item" data-toggle="tooltip" title="کانال تلگرام"
                                   data-placement="bottom"
                                   href="https://www.t.me/{{$social->value}}">
                                    <i class="fab fa-telegram text-white fa-2x"></i>
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
        </div>
        <!-- Footer -->
        <footer class="row bg-black py-2">
            <div class="container">
                <div class="small text-center text-muted">*کلیه حقوق مادی و معنوی این وبسایت متعلق به املاک اصفهان  می باشد* </div>
            </div>
        </footer>
    </div>
</section>
<!-- /services Section -->
