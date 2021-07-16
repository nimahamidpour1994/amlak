@extends('front.index')

@section('title','صفحه اصلی')
@section('description','    املاک اصفهان به جستجوی آسان برای فروش ملک برای فروش یا اجاره و می پردازد. از ویژگی نقشه برای موقعیت مکانی منحصر به فرد خود برای پیدا کردن ویلای ایده آل، خانه شهری یا آپارتمان استفاده کنید و با صاحبان اصلی تماس بگیرید. ما فقط چند ثانیه به شما کمک خواهیم کرد خانه رویایی خود را پیدا کنیم. .ما مشتریان خود را با تمام جنبه های خرید و فروش خانه به مشتریان خود ارائه می دهیم. این سایت به شما کمک می کند تا خانه رویایی خود را جستجو کنید، بحث در مورد تحولات جدید املاک و یا کمک به فروش اموال شما، ما این فرصت را برای کمک را دوست داریم. لطفا برای سؤالات خود با ما تماس بگیرید!')

@section('keywords','    فروش اپارتمان در اصفهان - اجاره اپارتمان در اصفهان - فروش خانه ویلایی در اصفهان - اجاره خانه ویلایی در اصفهان - فروش باغ در اصفهان - اجاره خانه مبله در اصفهان')


@section('content')


    <!-- MAIN CODE -->
    <div class="container-fluid mt-lg-4 mt-3">

        <div class="row">

            <!--START RIGHT-SIDE-CODE-->
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right sticky-top">
                    <div class="d-none d-xl-block d-lg-block" style="margin-top: 80px!important;">

                        <!-- FILTER BOX -->
                        <div id="filterBox" class="mb-3 font-iran"></div>
                        <!-- FILTER BOX -->

                        <!-- CHOOSE CATEGORY -->
                        <div class="col-12 p-0 m-0 border-bottom pb-2 d-xl-modal">
                            <h2 class="font-size-15 text-right font-weight-bold">دسته بندی ها</h2>
                            <div class="py-2" id="category_descktop">

                                <ul  class="filter-category-list mr-4">
                                    @foreach($response['categories'] as $category)
                                        <li class="filter-category-list__item filter-category-list__item--inactive font-size-14"
                                            onclick="openSubCategory('{{$category->id}}','parent')">
                                            {{$category->name}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- CHOOSE CATEGORY -->

                        <!-- CHOOSE STATE -->
                        <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                            <li class="my-3 list-none">
                                <a class="text-decoration-none" data-toggle="collapse"
                                   href="#pricefilter" role="button" aria-expanded="false"
                                   aria-controls="pricefilter">
                                     <span class="text-dark font-size-14 bold text-right" id="statefilter">محل</span>
                                    <i class="fas fa-angle-down filter-open mt-1 text-dark"></i>
                                </a>
                            </li>

                            <li class="collapse multi-collapse p-0 my-3 list-none"  id="pricefilter">
                                <select class="form-control font-iran font-size-14" id="state" style="width: 200px;" onchange="changeCondition('statefilter','state',this)">
                                    @foreach($response['state'] as $state)
                                         <option class="align-right align-middle font-size-12" value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>

                            </li>
                        </ul>
                        <!-- CHOOSE STATE -->

                        <!-- CHOOSE ONLY IMAGE -->
                        <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                            <li class="my-2 list-none">
                                <label for="haveimg" class="text-dark font-size-14 bold text-right cursor-pointer" id="imgfilter">فقط عکس دارها</label>
                                <div class="custom-control custom-switch d-inline-block filter-open">
                                    <input type="checkbox" class="custom-control-input" id="haveimg"  onchange="changeCondition('imgfilter','img',this)">
                                    <label class="custom-control-label checkbox-open" for="haveimg"></label>
                                </div>
                            </li>
                        </ul>
                        <!-- CHOOSE ONLY IMAGE -->

                        <!-- CHOOSE ONLY URGENT -->
                        <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                            <li class="my-2 list-none">
                                <label for="haveurgent" class="text-dark font-size-14 bold text-right cursor-pointer" id="urgentfilter">فقط فوری ها</label>
                                <div class="custom-control custom-switch d-inline-block filter-open">
                                    <input type="checkbox" class="custom-control-input" id="haveurgent"  onchange="changeCondition('urgentfilter','urgent',this)">
                                    <label class="custom-control-label checkbox-open" for="haveurgent"></label>
                                </div>
                            </li>
                        </ul>
                        <!-- CHOOSE ONLY URGENT -->

                        <!-- CHOOSE WHO: AGENT,PERSON -->
                        <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                            <li  class="my-3 list-none">
                                <a class="text-decoration-none" data-toggle="collapse"
                                   href="#whofilters" role="button" aria-expanded="false"
                                   aria-controls="pricefilter">
                                    <span class="text-dark font-size-14 bold text-right" id="whofilter">آگهی دهنده</span>
                                    <i class="fas fa-angle-down filter-open mt-1 text-dark"></i>
                                </a>
                            </li>

                            <li class="collapse multi-collapse p-0 my-3 list-none"  id="whofilters">
                                <select class="form-control font-iran font-size-14" id="who" onchange="changeCondition('whofilter','who',this)">
                                    <option value="" hidden>انتخاب کنید</option>
                                    <option class="align-right align-middle font-size-12" value="person">شخصی</option>
                                    <option class="align-right align-middle font-size-12" value="agent">مشاور املاک</option>
                                </select>
                            </li>
                        </ul>
                        <!-- CHOOSE WHO: AGENT,PERSON -->

                        <!-- CUSTOM FILTER -->
                        <div class="mx-auto mb-3 m-0 p-0 col-12" id="custom_id"> </div>
                        <!-- CUSTOM FILTER -->

                        <div class="mx-auto mb-3 m-0 p-0 col-12">
                            <a target="_blank" href="https://trustseal.enamad.ir/?id=141853&amp;Code=LqJLzFpu1TIazVj2GFDY"><img src="https://Trustseal.eNamad.ir/logo.aspx?id=141853&amp;Code=LqJLzFpu1TIazVj2GFDY" alt="" style="cursor:pointer" id="LqJLzFpu1TIazVj2GFDY"></a>
                        </div>

                    </div>
                </div>
            </div>
            <!--END RIGHT-SIDE-CODE-->

            <!--START LEFT-SIDE-CODE-->
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12">

            <!--SEARCH BOX-->
            <div class="row">

                <!-- SEARCH DESKTOP -->
                <div class="d-none d-lg-block col-12 direction-rtl text-right pb-5" style="margin-top: 80px!important;">
                        <div class="input-group search-box-desktop">
                            <div id="input-button-div">
                                <button class="btn font-iran shadow-none text-dark bold button-search rounded-0 text-right pr-0" id="input-button"
                                        onclick="showCategoryList()">
                                    <i class="fa fa-angle-down down-arrow-item text-dark"></i>
                                    <span class="font-size-14" id="btn_search_span">همه آگهی ها</span>
                                </button>
                                <div class="drowp-down-search" id="drowp-down-search">

                                    <button class="btn font-iran font-size-14 text-black
                                     shadow-none text-right py-2 pr-3 dropdown-item-btn" onclick="openSubCategory(1,'parent')">
                                        همه آگهی ها
                                    </button>

                                    @foreach($response['categories'] as $category)

                                        <button class="btn font-iran font-size-14 text-black shadow-none text-right py-2 pr-2 dropdown-item-btn" onmouseenter="hoverSuggest({{$category->id}})">
                                            <i class="fa fa-angle-left text-secondary left-arrow-item"></i>

                                            {{$category->name}}
                                        </button>

                                    @endforeach
                                </div>
                            </div>
                            <div id="input-search-div">
                                <input class="form-control direction-rtl text-right fa-num font-size-14 my-0 input-search shadow-none" id="searchBox" autocomplete="off"
                                       type="text" placeholder="جستجو در همه آگهی ها" aria-label="Search">
                                <div class="hover-suggest rounded-0 border" id="hover-suggest"></div>
                                <div id="suggest"></div>
                            </div>
                        </div>
                </div>
                <!-- SEARCH DESKTOP -->

                <!-- SEARCH,CATEGORY,FILTER MODAL BTN -->
                <div class="d-lg-none col-12  pb-2" style="margin-top: 70px!important;">
                        <div class="direction-ltr text-right">
                            <div class="input-group">
                                <input class="form-control my-0 direction-rtl text-right
                                        fa-num font-size-14 search_box shadow-none" id="searchBoxMobile" style="height: 50px"
                                       type="text" placeholder="جستجو در همه آگهی ها" aria-label="Search"
                                        autocomplete="off">
                            </div>
                            <div id="suggestMobile"></div>
                        </div>
                        <div class="action-bar-container pr-1">
                            <div class="action-bar" id="filter_box_mobile">

                                <!-- CATEGORY -->
                                <button class="shadow-none mobile-btn" data-toggle="modal" data-target="#modal_category" id="category-mobile-btn" onclick="deleteCategoryMobile()">
                                    <i class="fa fa-list" id="category-mobile-i"></i>&nbsp;
                                    <span id="category-mobile-span">دسته بندی</span>
                                </button>

                                <!-- FILTER -->
                                <button class="mobile-btn" data-toggle="modal" data-target="#modal_filter" id="filter-mobile-btn">
                                    <i class="fa fa-filter" id="filter-mobile-i"></i>&nbsp;
                                    <span id="filter-mobile-span" class="fa-num">فیلترها</span>
                                </button>


                            </div>
                        </div>
                </div>
                <!-- SEARCH,CATEGORY,FILTER MODAL BTN -->

            </div>
            <!--SEARCH BOX-->

            <div class="row mt-1 mt-xl-3 mt-lg-3 px-2" id="blog_view">

            </div>

            <!-- HELP BAR -->
            <div>
                  <span class="font-size-12 text-secondary direction-rtl text-right" id="category_help_status">
                    {{$response['app_name']}} - {{$response['app_issue']}}
                  </span>
                <input type="hidden" id="hidden_name" value=" {{$response['app_name']}}">
                <input type="hidden" id="hidden_issue" value="{{$response['app_issue']}}">
             </div>
            <!-- HELP BAR -->

            <!-- ADVERTISMENT -->
             <section class="page-section border-top ">
                    <div class="container">
                        <div class="row" id="load_data">
                            @foreach($response['advertisments'] as $advertisment)
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <a href="{{route('app.show.advertisment',$advertisment->slug)}}" target="_blank" class="text-decoration-none">
                                        <div class="border-none border-bottom-1 mb-3 single-card">
                                            <div class="row no-gutters">

                                                <!-- IMAGE -->
                                                <div class="col-6">
                                                    <span class="bg-divar text-white rounded btn-sm position-absolute fa-num font-size-12 m-2 bold">کد :  {{$advertisment->id}}</span>
                                                    <img
                                                        src="{{url($advertisment->icon !='' ? 'storage/advertisment/thumbnail/'.$advertisment->icon : 'front/img/structure/'.\App\Models\Setting::firstWhere('key','defualt-img')->value)}}"
                                                        class="img-cadr-main" alt="{{$advertisment->name}}">
                                                </div>
                                                <!-- IMAGE -->

                                                <!-- INFO -->
                                                <div class="col-6 min-100">
                                                    <div class="card-body p-0">

                                                        <!-- TITLE -->
                                                        <h2 class="d-flex direction-rtl card-title mb-1 card-title-style fa-num  font-size-14 text-right text-black"
                                                            style="min-height: 62px!important;">{{mb_substr(strip_tags($advertisment->name),0,50,'UTF8')}}</h2>
                                                        <!-- TITLE -->

                                                        <!-- SHOW THUMBNAIL -->
                                                        <div class="text-right" style="min-height:55px">
                                                            @foreach($advertisment->scopeMetaKey('','field')->get() as $meta)
                                                                @if($meta->Form->show_thumbnail==1)
                                                                    <h2 class="text-right text-dark font-size-12 bold direction-rtl mt-0 fa-num">
                                                                        {{$meta->Form->name}}
                                                                        :
                                                                        {{is_numeric($meta->value) ? number_format($meta->value) : $meta->value }}
                                                                        <span
                                                                            class="font-iran text-danger bold p-0">{{$meta->Form->unit}}</span>
                                                                    </h2>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <!-- SHOW THUMBNAIL -->

                                                        <!-- SHOW URGENT,NARDEBAN,TIME -->
                                                        <div class="d-flex flex-column  mb-1 direction-rtl">
                                                            <div class="d-flex flex-row">
                                                                <!-- urgent advertisments -->
                                                                @if(\App\Models\OrderDetail::firstwhere([['advertisment',$advertisment->id],['pay','paid'],
                                                                    ['plan','urgent'],['created_at','>',\Carbon\Carbon::now()->subDays(optional(\App\Models\Plan::where('key','urgent')->first())->expire)]]))
                                                                    <p class="card-text card-text-style">
                                                                        <span class="border border-danger rounded btn-fory mx-1 px-1 text-danger font-iran font-size-12 bold">فوری</span>
                                                                        <small class="text-muted fa-num">
                                                                            در {{$advertisment->State->name}}</small>
                                                                    </p>
                                                                @else
                                                                    <p class="card-text card-text-style text-right">
                                                                        <small class="text-muted fa-num font-size-12">
                                                                            @if(strlen($advertisment->updated_at->diffForHumans().' در '.$advertisment->State->name) > 25)
                                                                                 {{mb_substr(strip_tags($advertisment->updated_at->diffForHumans().' در '.$advertisment->State->name),0,22,'UTF8').'...'}}
                                                                            @else
                                                                                {{$advertisment->updated_at->diffForHumans().' در '.$advertisment->State->name}}
                                                                            @endif
                                                                        </small>
                                                                    </p>

                                                            @endif
                                                            <!-- urgent advertisments -->
                                                            </div>
                                                        </div>
                                                        <!-- SHOW URGENT,NARDEBAN,TIME -->

                                                    </div>
                                                </div>
                                                <!-- INFO -->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center d-none" id="loading">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </section>
             <!-- ADVERTISMENT -->

            </div>
            <!--END LEFT-SIDE-CODE-->

        </div>
    </div>
    <!-- MAIN CODE -->

    <!-- MODAL CATEGORY -->
    <div class="modal fade right" style="z-index: 5000!important;" id="modal_category" tabindex="-1" role="dialog" aria-labelledby="modal_category" aria-hidden="true">
        <div class="modal-dialog-full modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full modal-content">
                <div class="modal-header-full modal-header text-center" style="height: 50px">
                    <h2 class="modal-title w-100 font-size-1rem bold text-right text-black mt-1 cursor-pointer"
                         id="mobile_category_name">
                        دسته بندی ها
                    </h2>
                    <button class="close text-left pl-0 ml-0 text-black" style="outline: none" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-black">×</span>
                    </button>
                </div>
                <div class="modal-body text-right">
                    <ul id="category_mobile" class="p-0 font-size-14 mt-1">
                        @foreach($response['categories'] as $category)
                            @if(count($category->Child) > 0)
                                <li class="nav-item cursor-pointer list-none py-3 px-0 m-0 border-bottom"
                                        onclick="openSubCategoryMobile('{{$category->id}}','parent')">
                                    {{$category->name}}
                                    <i class="fas fa-chevron-left filter-open text-secondary"></i>
                                </li>
                            @else
                                <li class="nav-item cursor-pointer list-none py-3 px-0 m-0 border-bottom"
                                    onclick="openSubCategoryMobile('{{$category->id}}','child')">
                                    {{$category->name}}
                                    <i class="fas fa-chevron-left filter-open text-secondary"></i>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL CATEGORY -->

    <!-- MODAL Filter -->
    <div class="modal fade right" style="z-index: 5000!important;" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="modal_filter" aria-hidden="true">
        <div class="modal-dialog-full modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full modal-content">

                <div class="modal-header-full modal-header text-center" style="height: 50px">
                    <h2 class="modal-title w-100 font-size-1rem bold text-right text-black mt-1">فیلترها</h2>
                    <button type="button" class="text-black btn p-0 m-0"  style="outline: none" data-dismiss="modal" aria-label="Close" onclick="deleteConditionMobile()">
                        <span class="font-size-15rem text-black filter-open bold p-0 m-0" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-right">

                    <!-- CHOOSE STATE -->
                    <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                        <li style="list-style: none" class="mb-3">
                            <a class="text-decoration-none" data-toggle="collapse"
                               href="#pricefilter" role="button" aria-expanded="false"
                               aria-controls="pricefilter">
                                <span class="text-dark font-size-14 bold text-right" id="statefilter">محل</span>
                                <i class="fas fa-angle-down filter-open mt-1 text-dark"></i>
                            </a>
                        </li>

                        <li class="collapse multi-collapse p-0 my-3" style="list-style: none" id="pricefilter">
                            <select class="form-control font-iran font-size-14" id="state_mobile" style="width: 100%;" onchange="changeConditionMobile('statefilter','state',this)">
                                @foreach(\App\Models\State::where('parent','=',\Illuminate\Support\Facades\Cookie::get('city'))->get() as $state)
                                    <option class="align-right align-middle font-size-12" value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            </select>

                        </li>
                    </ul>
                    <!-- CHOOSE STATE -->

                    <!-- CHOOSE ONLY IMAGE -->
                    <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                        <li style="list-style: none" class="my-3">
                            <span class="text-dark font-size-14 bold text-right" id="imgfilter">فقط عکس دارها</span>
                            <div class="custom-control custom-switch d-inline-block filter-open">
                                <input type="checkbox" class="custom-control-input" id="haveimg-mobile"  onchange="changeConditionMobile('imgfilter','img',this)">
                                <label class="custom-control-label checkbox-open" for="haveimg-mobile"></label>
                            </div>
                        </li>
                    </ul>
                    <!-- CHOOSE ONLY IMAGE -->

                    <!-- CHOOSE ONLY URGENT -->
                    <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                        <li style="list-style: none" class="my-3">
                            <span class="text-dark font-size-14 bold text-right" id="urgentfilter">فقط فوری ها</span>
                            <div class="custom-control custom-switch d-inline-block filter-open" >
                                <input type="checkbox" class="custom-control-input" id="haveurgent-mobile"  onchange="changeConditionMobile('urgentfilter','urgent',this)">
                                <label class="custom-control-label checkbox-open" for="haveurgent-mobile"></label>
                            </div>
                        </li>
                    </ul>
                    <!-- CHOOSE ONLY URGENT -->

                    <!-- CHOOSE WHO: AGENT,PERSON -->
                    <ul class="mx-auto mb-3 m-0 p-0 border-bottom">
                        <li style="list-style: none" class="my-3">
                            <a class="text-decoration-none" data-toggle="collapse"
                               href="#whofilters-mobile" role="button" aria-expanded="false"
                               aria-controls="pricefilter">
                                <span class="text-dark font-size-14 bold text-right" id="whofilter-mobile">آگهی دهنده</span>
                                <i class="fas fa-angle-down filter-open mt-1 text-dark"></i>
                            </a>
                        </li>

                        <li class="collapse multi-collapse p-0 my-3" style="list-style: none" id="whofilters-mobile">
                            <select class="form-control font-iran font-size-14" id="who-mobile" onchange="changeConditionMobile('whofilter-mobile','who',this)">
                                <option value="" hidden>انتخاب کنید</option>
                                <option class="align-right align-middle font-size-12" value="person">شخصی</option>
                                <option class="align-right align-middle font-size-12" value="agent">مشاور املاک</option>
                            </select>

                        </li>
                    </ul>
                    <!-- CHOOSE WHO: AGENT,PERSON -->

                    <!-- CUSTOM FILTER -->
                    <div class="mx-auto mb-3 m-0 p-0" id="custom_mobile_id">

                    </div>
                    <!-- CUSTOM FILTER -->
                </div>

                <div class="modal-footer">
                    <button class="btn bg-divar text-white font-iran w-100 font-size-1rem" onclick="saveConditionMobile()" data-dismiss="modal" aria-label="Close" >اعمال فیلتر(ها)</button>
                </div>

            </div>
        </div>
    </div>
    <!-- MODAL Filter -->

@endsection




@section('script')
    <script type="text/javascript">

        $('#state').select2();

            // WHEN BACK WITH OTHER CATEGORY DESKTOP
            @if(isset($response['back_category']) && $response['back_category'] !== null && !isset($response['back_state']) )
                    openSubCategory('{{$response['back_category']->id}}','parent');
                    {{--openSubCategoryMobile('{{$response['back_category']->id}}','child');--}}
            @endif


            // WHEN BACK WITH OTHER CATEGORY AND THIS STATE DESKTOP
            @if(isset($response['back_state_desktop']) && $response['back_state_desktop'] !== null)
                $('#state').val('{{$response['back_state_desktop']}}');
                openSubCategoryChangCondition('{{$response['back_category']->id}}','parent');
            @endif

            // WHEN BACK WITH OTHER CATEGORY AND THIS STATE MOBILE
            @if(isset($response['back_state_mobile']) && $response['back_state_mobile'] !== null)
                $('#state_mobile').val('{{$response['back_state_mobile']}}');
               openSubCategoryChangConditionMobile('{{$response['back_category']->id}}','parent');
            @endif

            lazyload();

          $(window).click(function(){
              document.getElementById('suggest').innerHTML='';
              $('#hover-suggest').css('display','none');
          });

          document.getElementById('searchBox').addEventListener("keyup", function(event) {
              // Number 13 is the "Enter" key on the keyboard
              if (event.keyCode === 13)
              {
                  // Cancel the default action, if needed
                  event.preventDefault();
                  // Trigger the button element with a click
                  suggest('changeCondition');

                  document.getElementById('searchBox').blur();
              }
              else{
                  suggest('suggest');
              }
          });

        $(document).mouseup(function(e){
            var container = $("#input-button-div");

            // If the target of the click isn't the container
            if(!container.is(e.target) && container.has(e.target).length === 0){
                $('#drowp-down-search').hide('slow');
            }
        });


          // SEARCH BOX SCRIPT FOR KEYP,ENTER AND ONCLICK DESKTOP
          $(window).click(function(){
              document.getElementById('suggestMobile').innerHTML='';
          });

          document.getElementById('searchBoxMobile').addEventListener("keyup", function(event)
          {
              // Number 13 is the "Enter" key on the keyboard
              if (event.keyCode === 13)
              {
                  // Cancel the default action, if needed
                  event.preventDefault();
                  // Trigger the button element with a click
                  suggestMobile('changeCondition');
                  document.getElementById('searchBox').blur();
              }
              else{
                  suggestMobile('suggest');
              }
          });

    </script>
@endsection
