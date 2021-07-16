@extends('user.index')

@section('title','پیش نمایش آگهی  ')
@section('description','')


@section('content')

<section>

    <!-- MANAGE AND DELETE ADVERTISMENT -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12  ">
                <h2 class="text-right font-yekan bold font-size-14">مدیریت آگهی
                    @if($response['advertisment']->created_at > \Carbon\Carbon::now()->subDays($response['expire_day']))
                        @if($response['advertisment']->show === 'waiting')
                            <span class="ext-orange font-size-14 font-yekan">({{$response['advertisment']->Status->unique}})</span>
                            &nbsp;
                        @elseif($response['advertisment']->show ==='success')
                            <span class="text-success font-size-14 font-yekan">({{$response['advertisment']->Status->unique}})</span>
                            &nbsp;
                        @else
                            <span class="text-danger font-size-14 font-yekan">({{$response['advertisment']->Status->unique}})</span>&nbsp;
                        @endif
                    @else
                        <span class="text-danger font-size-14 font-yekan">(منقضی شده)</span>&nbsp;
                    @endif
                </h2>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">

                <a class="btn btn-outline-red btn-sm bold font-iran" href="#" data-toggle="modal" data-target="#logoutModal">
                    حذف آگهی
                </a>

            </div>
        </div>
    </div>

    <!-- ADVERTISMENT INFO -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-sm-12 mx-aut ">
                    <nav>
                        <div class="d-flex flex-nowrap  nav nav-tabs nav-fill " id="nav-tab" role="tablist">
                            <a class="nav-item nav-link  border-none font-size-14 active"
                               href="{{route('user.advertisment.preview',$response['advertisment']->slug)}}">پیش نمایش آگهی</a>
                            <a class="nav-item nav-link border-none font-size-14 text-dark"
                               href="{{route('user.order.create',$response['advertisment']->slug)}}">ارتقا</a>
                            <a class="nav-item nav-link border-none font-size-14 text-dark  "
                               href="{{route('user.advertisment.edit',$response['advertisment']->slug)}}">ویرایش</a>
                            <a class="nav-item nav-link border-none font-size-14 text-dark  "
                               href="{{route('user.chat.list',$response['advertisment']->slug)}}">لیست پیام ها</a></div>

                    </nav>

                    <div class="py-3 px-3 px-sm-0">
                        <section class="page-section">

                            <div class="row direction-ltr">

                                <!-- GALLERY IMAGE -->
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center mx-auto">
                                    <div class="row">
                                        <div class="col-12 text-center mx-auto">
                                            <div id="carouselExampleIndicators"
                                                 class="carousel slide mx-auto text-center mb-4" data-ride="carousel">
                                                <ol class="carousel-indicators mx-auto text-center">
                                                    <li data-target="#carouselExampleIndicators"
                                                        data-slide-to="{{$i=0}}" class="active"></li>
                                                    @foreach($response['images'] as $image)
                                                        <li data-target="#carouselExampleIndicators"
                                                            data-slide-to="{{++$i}}"></li>

                                                    @endforeach
                                                </ol>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="rounded img-fluid"
                                                             src="{{url(($response['advertisment']->icon!='' ? 'storage/advertisment/'.$response['advertisment']->icon : 'front/img/structure/'.\App\Models\Setting::firstWhere('key','defualt-img')->value ))}}"
                                                             alt="{{$response['advertisment']->name}}">
                                                    </div>
                                                    @foreach($response['images'] as $image)
                                                        <div class="carousel-item">
                                                            <img class="rounded img-fluid"
                                                                 src="{{url('storage/advertisment/'.$image->value)}}"
                                                                 alt="{{$response['advertisment']->name}}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleIndicators"
                                                   role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleIndicators"
                                                   role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- MAP AND SHARE LINK -->
                                        <div class="col-11 d-none d-xl-block d-lg-block text-center mx-auto">

                                            <!-- SHARE LINK -->
                                            <div class="row border border-2 py-3 direction-ltr" style="cursor: pointer"
                                                 title="کپی لینک" onclick="sharelink('share-device')">
                                                <input type="text" id="share-device"
                                                       class="col-7 p-1 btn font-iran text-left font-size-14 text-black"
                                                       value="{{$response['app_url']}}/v/{{$response['advertisment']->slug}}"
                                                       readonly>
                                                <span class="col-5 text-right font-size-14 text-black">
                                                    <span class="d-none d-xl-inline-block d-lg-inline-block d-md-inline-block"> لینک به اشتراک گذاری</span>
                                                    <i class="far fa-copy text-black font-size-17"></i>
                                                </span>
                                            </div>

                                            <!-- MAP -->
                                            <div class="row mt-4 {{$response['advertisment']->latitude!='' ? '' : 'd-none'}}">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                                                    <div id="map-xl" class="col-12" style="height: 275px;width: 100%">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MAP -->

                                            <!--TEXT -->
                                            <div class="font-size-12 direction-rtl text-right mt-4 pb-3 border-bottom">
                                                {{$response['advertisment_warning']}}
                                            </div>
                                            <!--TEXT -->


                                        </div>
                                        <!-- MAP AND SHARE LINK -->
                                    </div>
                                </div>
                                <!-- GALLERY IMAGE -->

                                <!-- INFO -->
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 direction-rtl">
                                    <!-- ADDVERTISMENT NAME -->
                                    <div class="row d-flex">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div
                                                class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 my-1 p-0 align-right">
                                                <h1 class="fa-num text-black font-size-20 bold p-0 mb-3 text-right">
                                                    {{$response['advertisment']->name}}
                                                </h1>
                                                @if(\App\Models\OrderDetail::firstwhere([['advertisment',$response['advertisment']->id],
                                                       ['plan','urgent'],['created_at','>',\Carbon\Carbon::now()->subDays(optional(\App\Models\Plan::firstWhere('key','urgent'))->expire)]]))
                                                    <span  class="bold p-0 rounded text-danger font-iran font-size-14 bold">فوری</span>
                                                @endif
                                                <span
                                                    class="fa-num text-muted font-size-14  align-right mx-3">{{$response['advertisment']->created_at->diffForHumans()}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ADDVERTISMENT INFO -->
                                    <div class="row d-flex">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-6 my-3 ">
                                            <table class="table border-bottom">
                                                <tbody>
                                                <tr>
                                                    <td scope="row" class="align-right p-3 font-size-15">دسته آگهی</td>
                                                    <td class="fa-num p-3 font-size-14">{{$response['advertisment']->Category->name}}</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row" class="align-right p-3 font-size-15">محل</td>
                                                    <td class="fa-num p-3 text-divar font-size-14">{{$response['advertisment']->State->Parent->name}}
                                                        ، {{$response['advertisment']->State->name}}</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row" class="align-right p-3 font-size-15">تلفن</td>
                                                    <td class="fa-num p-3 font-size-14"> {{$response['advertisment']->mobile}}</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="align-right p-3 font-size-15">کــد آگهـی</td>
                                                    <td class="fa-num p-3 font-size-14">{{$response['advertisment']->id}}</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="align-right p-3 font-size-15">آگهی‌دهنده</td>
                                                    <td class="fa-num p-3 font-size-14">{{$response['advertisment']->who==='agent' ? 'مشاور املاک' : 'شخصی'}}</td>
                                                </tr>
                                                @foreach($response['metas'] as $meta)
                                                    @if(isset($meta->Form->name))
                                                        <tr>
                                                            <td scope="row"
                                                                class="align-right p-3 font-size-15">{{$meta->Form->name}}</td>
                                                            <td class="fa-num p-3 font-size-14">{{is_numeric($meta->value) && strlen($meta->value)>4 ? number_format($meta->value) : $meta->value}}
                                                                &nbsp;<span
                                                                    class="font-size-14  text-danger">{{$meta->form->unit}}</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div
                                            class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-6 fa-num text-justify direction-rtl line-35 font-size-14 mb-3">
                                            {!! str_replace(PHP_EOL,"<br/>",$response['advertisment']->details) !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- INFO -->

                                <!-- MAP AND SHARE LINK -->
                                <div class="col-12 d-block d-xl-none d-lg-none direction-rtl">

                                    <!-- SHARE LINK -->
                                    <div class="row border border-2 py-3 direction-ltr" style="cursor: pointer"
                                         title="کپی لینک" onclick="sharelink('share-mobile')">
                                        <input type="text" id="share-mobile"
                                               class="col-10 btn btn-light font-iran text-left px-1 py-0 font-size-12 bold text-black"
                                               value="{{$response['app_url']}}/v/{{$response['advertisment']->slug}}" readonly>
                                        <span class="col-2 text-right font-size-1rem bold  text-black">
                                            <span class="d-none d-xl-inline-block d-lg-inline-block d-md-inline-block"> لینک به اشتراک گذاری</span>
                                            <i class="far fa-copy text-black font-size-17"></i>
                                        </span>
                                    </div>

                                    <!-- MAP -->
                                    <div class="row mt-4 {{$response['advertisment']->latitude!='' ? '' : 'd-none'}}">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                                            <div id="map-sm" class="col-12" style="height: 275px;width: 100%">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- MAP -->

                                    <!--TEXT -->
                                    <div class="font-size-14 direction-rtl text-right mt-4 pb-3 border-bottom">
                                        {{$response['advertisment_warning']}}
                                    </div>
                                    <!--TEXT -->

                                </div>
                                <!-- MAP AND SHARE LINK -->

                            </div>

                            <div class="row">
                                <div class="col-xl-7 col-lg-7 col-md-6 col-sm-12 col-xs-12 mt-5">
                                    <h2 class="text-black font-size-20 bold mb-3 text-right">آمـار آگهی </h2>
                                    <p class="font-size-14 text-muted text-right">
                                        آمار تعداد بازدید روزانه آگهی شما از زمان انتشار آگهی در این نمودار قابل مشاهده است.

                                    </p>
                                </div>

                                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 col-xs-12  mt-xl-5 pt-xl-5">

                                    <div class="text-right">
                                        <span class="text-dark font-size-14 bold">بازدید کلی : </span>
                                        <span class="text-dark font-size-14 fa-num"> {{ $response['view_all']}}</span>
                                    </div>
                                    <div class="post-stats__graph">
                                        @if($response['max_view_count'] > 0 )
                                            @for($i=6 ;$i >= 0;$i--)
                                                <div class="post-stats__bar"
                                                     style="height: {{(($response['view_count'][$i] * 100)/$response['max_view_count'])}}px">
                                                    <div class="post-stats__visits fa-num">{{$response['view_count'][$i]}}</div>
                                                    <div class="post-stats__title fa-num">{{$response['view_date'][$i]}}</div>
                                                </div>
                                            @endfor
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ADVERTISMENT DELETE MODAL -->
    <div class="modal fade mt-5" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="direction:rtl!important;text-align:right;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header direction-ltr text-right">

                    <h5 class="modal-title" id="exampleModalLabel">آگهی شما حذف شود؟</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="float:right!important;">×</span>
                    </button>

                </div>
                <div class="modal-body">
                    اگر مطمعن هستید که آگهی خود را حذف کنید، ادامه دهید
                </div>
                <div class="modal-footer">
                    <a href="{{route('user.advertisment.destroy',$response['advertisment']->id)}}"
                       class="btn btn-danger font-iran bold font-size-14">
                        حذف آگهی
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection


@section('script')
    <script>
        show_map('{{$response['advertisment']->latitude}}', '{{$response['advertisment']->longitude}}', 'map-xl');
        show_map('{{$response['advertisment']->latitude}}', '{{$response['advertisment']->longitude}}', 'map-sm');
    </script>


@endsection
