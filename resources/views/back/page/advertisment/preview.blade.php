@extends('back.index')

@section('content')

   <section class="page-section mx-5">

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

@endsection


@section('script')
    <script>
        show_map('{{$response['advertisment']->latitude}}', '{{$response['advertisment']->longitude}}', 'map-xl');
        show_map('{{$response['advertisment']->latitude}}', '{{$response['advertisment']->longitude}}', 'map-sm');
    </script>
@endsection
