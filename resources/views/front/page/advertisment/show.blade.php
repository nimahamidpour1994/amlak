@extends('front.index')

@section('title',$response['advertisment']->name)

@section('description',$response['advertisment']->name.' , '.$response['advertisment']->details)


@section('keywords',$response['advertisment']->name.' - '
                   .' آگهی فروش  ' . $response['advertisment']->Category->name.'-'
                    .' آگهی اجاره '.$response['advertisment']->Category->name.'-'.
                    ' آگهی در  '.$response['advertisment']->Status->name.' - '
                    .' آگهی فروش  ' .$response['advertisment']->Category->name.' '.$response['advertisment']->Status->name.' - '
                    .' آگهی اجاره  ' .$response['advertisment']->Category->name.' '.$response['advertisment']->Status->name)


@section('topnav')
    @include('front.top.navbar')
@endsection

@section('content')
    <section>

        <div class="container">
            <div class="row mx-auto direction-ltr" style="margin-top: 50px!important;">

                <div class="col-xl-12 col-lg-12 col-md-11 col-sm-11 col-xs-11 direction-rtl p-1 text-right border border-muted mb-5 mx-2" style="background: #FAFAFA">
                        <a class="category btn text-decoration-none border-left px-3 font-yekan font-size-14 shadow-none" href="{{route('app.home.back')}}">بازگشت</a>
                    @foreach(array_reverse($response['parent']) as $parent)
                        <a class="category btn text-decoration-none font-yekan font-size-12 shadow-none mx-0 px-0" href="{{route('app.home.category.back',$parent->id)}}">{{$parent->name}}</a><span>/</span>
                    @endforeach
                </div>

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
                                        <span class="bg-divar text-white rounded btn-sm position-absolute fa-num font-size-1rem m-4 bold">کــد :  {{$response['advertisment']->id}}</span>

                                        <img class="rounded img-fluid"
                                             src="{{url( ($response['advertisment']->icon!='' ? 'storage/advertisment/'.$response['advertisment']->icon : 'front/img/structure/'.\App\Models\Setting::firstWhere('key','defualt-img')->value ))}}"
                                             alt="{{$response['advertisment']->name}}" style="max-height:500px!important;border: 1px solid #f0f0f0">
                                    </div>
                                    @foreach($response['images'] as $image)
                                        <div class="carousel-item">
                                            <span class="bg-divar text-white rounded btn-sm position-absolute fa-num font-size-12 mx-2 my-3 bold">کــد :  {{$response['advertisment']->id}}</span>

                                            <img class="rounded img-fluid"
                                                 src="{{url('storage/advertisment/'.$image->value)}}"
                                                 alt="{{$response['advertisment']->name}}" style="max-height:500px!important;border: 1px solid #f0f0f0">
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
                            <div class="row border border-2 py-3 direction-ltr" style="cursor: pointer" title="کپی لینک" onclick="sharelink('share-device')">
                                <input type="text" id="share-device" class="col-7  p-1 btn font-iran text-left font-size-14 text-black" value="https://amlakesfahan.com/v/{{$response['advertisment']->slug}}" readonly>
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
                               {{$response['app_warning']}}
                            </div>
                            <!--TEXT -->

                            <!-- REPORT -->
                            <div class="direction-rtl text-left mt-4">
                                <a class="btn font-size-14 shadow-none text-decoration-none" href="#" data-toggle="modal" data-target="#reportmodel">
                                    <span>
                                            <i class="far fa-flag"></i>
                                        </span>
                                    <span>  گزارش مشکل آگهی </span>
                                </a>
                            </div>
                            <!-- REPORT -->

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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 my-1 p-0 align-right">
                                    <h1 class="fa-num text-black font-size-20 bold  p-0 mb-3 text-right">
                                        {{$response['advertisment']->name}}
                                    </h1>
                                    @if($response['ladder'] !== null)
                                        <span class="fa-num text-divar bold font-size-14 align-right">نـردبان</span>
                                    @endif
                                    @if($response['urgent'] !== null)
                                        <span class="fa-num text-divar bold font-size-14 align-right">فـوری</span>
                                    @endif
                                    <span class="fa-num text-muted font-size-14  align-right">{{$response['advertisment']->updated_at->diffForHumans()}}</span>
                                </div>
                            </div>
                        </div>

                         <!-- ADDVERTISMENT MOBILE -->
                        <div class="row d-flex py-2 direction-ltr">

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3 text-right text-xl-left text-lg-left">
                                @if($response['bookmark'] === null)
                                    <input type="button" class="btn btn-outline-secondary btn-sm font-iran px-3" value="نشان کردن" onclick="addMark(this,'{{$response['advertisment']->id}}')">
                                @else
                                    <input type="button" class="btn bg-divar text-white font-iran px-3 py-1" value="نشان شده" disabled>
                                @endif
                            </div>

                           <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 direction-rtl text-right">
                               <button class="btn btn-sm bg-divar  text-white shadow-none font-iran" data-toggle="collapse" data-target="#mobile">
                                   دریافت اطلاعات تماس
                               </button>

                               <a class="btn btn-outline-secondary btn-sm text-decoration-none font-iran mx-1" href="{{route('user.chat.create',$response['advertisment']->id)}}">
                                   <i class="far fa-comment"></i>
                                   ارسال پیام
                               </a>
                           </div>


                        </div>

                        <div class="row d-flex">
                            <div  class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 collapse my-3"
                                id="mobile">
                                <table class="table border-bottom">
                                    <tr>
                                        <td scope="row" class="align-right p-3">تلفـن</td>
                                        <td class="fa-num p-3">
                                            <a href="tel:{{$response['advertisment']->mobile}}"
                                             class="text-decoration-none fa-num text-divar font-size-14">{{$response['advertisment']->mobile}}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <p class="font-iran font-size-15 direction-rtl text-right line-35">
                                    <span class="bold"> هشدار پلیس:</span><br/>
                                   {{$response['police_fata']}}
                                </p>
                            </div>
                        </div>

                        <!-- ADDVERTISMENT INFO -->
                        <div class="row d-flex">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-6 my-3 ">
                            <table class="table border-bottom">
                                <tbody>
                                <tr>
                                    <td scope="row" class="align-right font-size-15 p-3">دسته آگهی</td>
                                    <td class="fa-num p-3 font-size-14">{{$response['advertisment']->Category->name}}</td>
                                </tr>
                                <tr>
                                    <td scope="row" class="align-right font-size-15 p-3">محل</td>
                                    <td class="fa-num p-3 text-divar font-size-14">{{$response['advertisment']->State->Parent->name}} ، {{$response['advertisment']->State->name}} </td>
                                </tr>

                                <tr>
                                    <td scope="row" class="align-right p-3 font-size-15">کــد ملک</td>
                                    <td class="fa-num p-3 font-size-14">{{$response['advertisment']->id}}</td>
                                </tr>
                                <tr>
                                    <td scope="row" class="align-right p-3 font-size-15">آگهی‌دهنده</td>
                                    <td class="fa-num p-3 font-size-14">{{$response['advertisment']->who === 'agent' ? 'مشاور املاک' : 'شخصی'}}</td>
                                </tr>

                                @foreach($response['more_info'] as $meta)
                                    @if(isset($meta->Form->name))
                                        <tr>
                                            <td scope="row" class="align-right p-3 font-size-15">{{$meta->Form->name}}</td>
                                            <td class="fa-num p-3 font-size-14">{{is_numeric($meta->value) && strlen($meta->value)>4 ? number_format($meta->value) : $meta->value}}
                                                &nbsp;<span
                                                    class="font-size-14 bold text-danger">{{$meta->Form->unit}}</span></td>
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

                        <div class="row d-none d-xl-block d-lg-block d-md-none d-sm-none d-xs-none ">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-6 my-5 text-right">
                                <span class="font-size-14 text-dark font-yekan d-block mb-2">آگهی بیشتر برای </span>
                                <a class="btn shadow-none text-divar font-yekan mr-3" href="{{route('app.desktop.home.category.state.back',$response['advertisment']->id)}}">{{$response['advertisment']->Category->name . ' در '.$response['advertisment']->State->name}}</a>
                            </div>
                        </div>
                    </div>
                <!-- INFO -->

                <!-- MAP AND SHARE LINK -->
                <div class="col-12 d-block d-xl-none d-lg-none direction-rtl">

                    <!-- SHARE LINK -->
                    <div class="row border border-2 py-3 direction-ltr" style="cursor: pointer" title="کپی لینک" onclick="sharelink('share-mobile')">
                        <input type="text" id="share-mobile" class="col-10 btn font-iran text-left px-1 py-0 font-size-12 text-black" value="https://amlakesfahan.com/v/{{$response['advertisment']->slug}}" readonly>
                        <span class="col-2 text-right font-size-14 text-black">
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
                        {{$response['app_warning']}}
                    </div>
                    <!--TEXT -->

                    <!-- REPORT -->
                    <div class="direction-rtl text-left mt-4">
                        <a class="btn font-size-14 shadow-none text-decoration-none" href="#" data-toggle="modal" data-target="#reportmodel">
                            <span>
                                <i class="far fa-flag"></i>
                            </span>
                            <span>  گزارش مشکل آگهی </span>
                        </a>
                    </div>
                    <!-- REPORT -->

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-6 my-5 text-right">
                            <span class="font-size-14 text-dark font-yekan d-block mb-2">آگهی بیشتر برای </span>
                            <a class="btn shadow-none text-divar font-yekan mr-3" href="{{route('app.mobile.home.category.state.back',$response['advertisment']->id)}}">{{$response['advertisment']->Category->name . ' در '.$response['advertisment']->State->name}}</a>
                        </div>
                    </div>

                </div>
                <!-- MAP AND SHARE LINK -->

             </div>
        </div>
    </section>



    <div class="modal fade direction-rtl" style="z-index: 5000!important" id="reportmodel" tabindex="-3" role="dialog"
         style="direction:rtl!important;text-align:right;">
        <div class="modal-dialog" style="max-width: 900px!important;" role="document">
            <div class="modal-content">

                <div class="modal-header direction-rtl">

                    <h3 class="modal-title font-size-15 text-black bold" id="exampleModalLabel">گزارش مشکل آگهی</h3>
                    <button class="close text-left pl-0 ml-0 text-black" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-black">×</span>
                    </button>

                </div>
                <form>
                    <div class="modal-body">
                            @csrf
                            <div class="form-row">
                                   <label class="font-size-14" for="report_type">دلیل های پیش فرض: </label>
                                   <select class="form-control font-iran font-size-14" id="report_type">
                                       <option value="" hidden>انتخاب دلیل گزارش</option>
                                       @foreach($response['report_category'] as $report)
                                           <option value="{{$report->unique}}">{{$report->unique}}</option>
                                       @endforeach
                                   </select>
                                <input type="hidden" value="{{$response['advertisment']->id}}" name="advertisment_id">
                              </div>
                            <div class="font-size-14 direction-rtl mt-4">لطفاً مشکل را شرح دهید و شمارهٔ موبایل خود را ثبت کنید. در صورت نیاز با شما تماس می‌گیریم.</div>
                            <div class="form-row">
                                <input type="number" class="form-control fa-num mt-3 font-size-14" placeholder="شماره تلفن(اختیاری)" name="report_mobile"
                                       id="report_mobile_id" value="{{isset(Auth()->user()->mobile) ? Auth()->user()->mobile  : ''}}"
                                    {{isset(Auth()->user()->mobile) ? 'readonly' : ''}}>
                            </div>
                            <div class="form-row">
                                <textarea  class="form-control fa-num mt-3 p-3 font-size-14" placeholder=" توضیحات(اختیاری)" id="report_details"></textarea>
                            </div>
                    </div>

                    <div class="row modal-footer mx-auto">
                        <div class="col-12 alert alert-success font-iran font-size-14 bold text-center d-none" id="success_report">گزارش شما با موفقیت ثبت گردید</div>

                        @auth
                            <input type="button" class="btn btn-danger font-iran bold font-size-14 d-block" value="ارسال گزارش" onclick="send_report()" id="btnSendReport">
                            <input type="button" class="btn btn-danger font-iran bold font-size-14 d-none" value="ارسال گزارش" data-toggle="modal" data-target="#loginmodelreport" id="btnLoginReport">
                        @else
                            <input type="button" class="btn btn-danger font-iran bold font-size-14 d-none" value="ارسال گزارش" onclick="send_report()" id="btnSendReport">
                            <input type="button" class="btn btn-danger font-iran bold font-size-14 d-block" value="ارسال گزارش" onclick="send_code('report')"data-toggle="modal" data-target="#loginmodelreport" id="btnLoginReport">
                        @endauth
                        <input type="button" class="btn btn-secondary rounded font-iran bold font-size-14"  data-dismiss="modal" aria-label="Close" value="بی خیال">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade direction-rtl" id="loginmodelreport" tabindex="-1" role="dialog"
         aria-hidden="true" style="direction:rtl!important;text-align:right;">
        <div class="modal-dialog" style="max-width: 600px!important;" role="document">
            <div class="modal-content">

                <div class="modal-header direction-rtl">
                    <h3 class="modal-title font-size-15 text-black bold" id="exampleModalLabel">ورود به حساب کاربری</h3>
                    <button class="close text-left pl-0 ml-0" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>
                <form action="{{route('login')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-row my-3">
                            <div class="col-12 alert alert-success font-iran font-size-14 bold text-center" id="successloginReport">کــد تایید برای شما پیامک شد</div>
                        </div>
                        <div class="form-row  my-3 mx-auto text-center">
                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-12 col-xs-12 mx-auto text-center">
                                <input value="" id="password-id" name="passwordReport" class="form-control rounded p-4 fa-num text-center mx-auto" type="text" placeholder="کــد تایید" >
                            </div>
                        </div>


                    </div>

                    <div class="row modal-footer mx-auto">
                        <div class="col-12 text-center">
                            <input type="button" class="btn btn-danger font-iran bold font-size-14 " style="width: 200px" id="loginReport" value="ورود" onclick="login_user('report')">
                        </div>
                        <div class="col-12 text-center mt-3" style="display: none" id="repeteReport">
                            <div class="mx-auto text-center fa-num bold" id="mobile_show_report"></div>
                            <input type="button" class="btn btn-light text-decoration-none font-iran text-danger font-size-14 text-center bold" onclick="send_code('report')" value="ارسال دوباره پیامک"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
            show_map('{{$response['advertisment']->latitude}}','{{$response['advertisment']->longitude}}','map-xl');
            show_map('{{$response['advertisment']->latitude}}','{{$response['advertisment']->longitude}}','map-sm');
    </script>
@endsection
