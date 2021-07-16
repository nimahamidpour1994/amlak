@extends('user.index')

@section('title',' آگهی های من - ')
@section('description','')


@section('content')

    <section>
        <div class="container mt-5">

            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-xs-12 col-sm-12 mx-auto">

                    <nav>
                        <div class="d-flex flex-nowrap  nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active border-none font-size-14"
                               href="{{route('user.dashboard')}}">
                                آگهی های من
                            </a>
                            <a class="nav-item nav-link border-none font-size-14 text-dark"
                               href="{{route('user.chat.list')}}">
                                لیست پیام ها
                            </a>
                            <a class="nav-item nav-link border-none font-size-14 text-dark"
                               href="{{route('user.bookmarks')}}">
                                آگهی های نشان شده
                            </a>
                            <a class="nav-item nav-link border-none font-size-14 text-dark"
                               href="{{route('user.recentseen')}}">
                                بازدیدهای اخیر
                            </a>
                             <a class="nav-item nav-link border-none font-size-1rem text-dark"
                                href="{{route('user.bell.list')}}">
                                لیست گوش به زنگ
                            </a>
                        </div>
                    </nav>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                           <div class="border-bottom">
                                <div class="form-row pt-4 pb-3">
                                        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12 direction-ltr mx-auto">
                                            <div class="input-group">


                                                <div class="input-group-prepend cursor-pointer" onclick="search('search')">
                                                     <span class="px-3 text-center search_box" style="background: #ededed!important;">
                                                         <i class="fas fa-search text-dark text-center  mt-3" aria-hidden="true"></i>
                                                     </span>
                                                </div>
                                                <input type="text" class="form-control my-0 py-1 text-right fa-num font-size-12 search_box shadow-none border-left-0 direction-rtl"
                                                       style="height: 50px" onchange="search('search')" id="key"  name="key"
                                                       placeholder="عنوان آگهی، کد ملک، شماره تماس و نام مالک">

                                                <div class="input-group-append direction-rtl text-right d-none d-xl-block d-lg-block">
                                                    <select name="category" id="category" onchange="search('category_desktop',this.value)"
                                                        class="form-control-sm fa-num font-size-14 shadow-none text-dark"
                                                        style="height: 50px;background-color: #ededed">
                                                        <option value="" class="text-divar bold">همه دسته ها</option>
                                                            @foreach($response['cats'] as $cat)
                                                                <option value="{{$cat['id']}}" class="fa-num mt-3">
                                                                    {{$cat['name']}}
                                                                </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                               <div class="d-lg-none action-bar-container direction-rtl">
                                   <div class="action-bar">
                                       <button class="mobile-btn d-none bg-divar text-white" data-toggle="modal"
                                               data-target="#modal_filter"
                                               onclick="search('category_mobile','')" id="parent_category">
                                           <span>همه دسته ها</span>
                                       </button>

                                       @foreach($response['cats'] as $cat)
                                           <button class="mobile-btn" data-toggle="modal" data-target="#modal_filter"
                                                   onclick="search('category_mobile','{{$cat['id']}}')"
                                                   id="btn{{$cat['id']}}">
                                               <span>{{$cat['name']}}</span>
                                           </button>
                                      @endforeach
                                   <!-- FILTER -->
                                   </div>
                               </div>
                           </div>


                            <div class="border-none card my-3" id="load_data">
                                @foreach($response['advertisments'] as $advertisment)
                                    <div class="row no-gutters border-bottom my-2">

                                        <!-- SHOW ICON -->
                                        <div
                                            class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-xl-center justify-content-lg-center justify-content-md-right justify-content-sm-right justify-content-xs-right mb-3">
                                            <img
                                                src="{{url(($advertisment->icon !== '' ? 'storage/advertisment/thumbnail/'.$advertisment->icon : 'front/img/structure/template.png' ))}}"
                                                class="img-cadr-main " alt="{{$advertisment->name}}">
                                        </div>

                                        <!-- SHOW TITLE AND FILED(SHOW THUMBNAIL) -->
                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 pt-1">
                                            <div class="card-body p-0">

                                                <h3 class="bold text-black font-size-15 fa-num text-right mb-3">
                                                    {{$advertisment->name}}
                                                </h3>
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

                                                    <div class="d-flex flex-column">
                                                        <p class="text-right mb-0">
                                                            <small
                                                                class="text-info bold font-size-12 fa-num">{{$advertisment->updated_at->diffForHumans() .' در '.$advertisment->State->name}}</small>
                                                        </p>
                                                    </div>
                                            </div>
                                        </div>

                                        <!-- SHOW CUSTOMER INFO IF EXIST -->

                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 text-right pt-1">
                                            @if($advertisment->owner_name!='')
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold">نام مالـک :</span>&nbsp;
                                                    <span
                                                        class="fa-num bold text-muted font-size-12 bold">{{$advertisment->owner_name}}</span>
                                                </div>
                                            @endif
                                            @if($advertisment->owner_mobile!='')
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold"> موبایل مالـک : </span>&nbsp;
                                                    <span
                                                        class="fa-num bold text-muted font-size-12 bold">{{$advertisment->owner_mobile}}</span>
                                                </div>
                                            @endif
                                            @if($advertisment->owner_price!='')
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold"> قیمت ملــک : </span>&nbsp;
                                                    <span
                                                        class="fa-num bold text-muted font-size-12 bold">{{$advertisment->owner_price}}</span>
                                                </div>
                                            @endif
                                            @if($advertisment->owner_address!='')
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold"> آدرس ملــک : </span>&nbsp;
                                                    <span
                                                        class="fa-num bold text-muted font-size-12 bold">{{$advertisment->owner_address}}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- SHOW STATE,EXPIRE,ADVERTISMENT ID , MANAGE ADVERTISMENT  -->
                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 pt-1">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold">وضعیت آگهی : </span>&nbsp;

                                                @if($advertisment->created_at > \Carbon\Carbon::now()->subDays($response['expire_day']))
                                                    @if($advertisment->show === 'waiting')
                                                        <span class="font-iran bold text-orange font-size-12 bold">{{$advertisment->Status->unique}}</span>
                                                        &nbsp;
                                                    @elseif($advertisment->show ==='success')
                                                        <span class="font-iran bold text-success font-size-12 bold">{{$advertisment->Status->unique}}</span>
                                                        &nbsp;
                                                    @else
                                                        <span class="font-iran bold text-danger font-size-12 bold">{{$advertisment->Status->unique}}</span>&nbsp;
                                                    @endif
                                                @else
                                                    <span class="font-iran bold text-danger font-size-12 bold">منقضی شده</span>&nbsp;
                                                @endif
                                                </div>
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold"> تاریخ انقضا : </span>&nbsp;
                                                    <span
                                                        class="fa-num bold text-danger font-size-12 bold">{{jdate($advertisment->created_at->addDays(\App\Models\Plan::firstWhere('key','extension')->expire))->format('Y.m.d')}}</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2">
                                                    <span class="font-iran font-size-12 bold"> کـد ملک : </span>&nbsp;
                                                    <span class="fa-num bold text-primary font-size-12 bold">{{$advertisment->id}}</span>
                                                </div>
                                                <div class="d-flex flex-row mb-2">
                                                    <div class="d-flex flex-column">
                                                        <a href="{{route('user.advertisment.preview',$advertisment->slug)}}"
                                                           class="btn btn-outline-danger btn-sm mx-1 font-iran font-size-12 bold">
                                                            مدیریت آگهی
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="floatingCirclesG" id="loading">
                                <div class="f_circleG" id="frotateG_01"></div>
                                <div class="f_circleG" id="frotateG_02"></div>
                                <div class="f_circleG" id="frotateG_03"></div>
                                <div class="f_circleG" id="frotateG_04"></div>
                                <div class="f_circleG" id="frotateG_05"></div>
                                <div class="f_circleG" id="frotateG_06"></div>
                                <div class="f_circleG" id="frotateG_07"></div>
                                <div class="f_circleG" id="frotateG_08"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection


@section('script')

    <script type="text/javascript">

        var text,category='';
        var  counter=1;
        var limit=10;
        var loading = false;
        var oldscroll = 0;

        lazyloadsearch();

        function search(type) {
            var value=document.getElementById("key").value;

            if(type==='category_desktop')
            {
                category=value;
                counter=0;
                load_advertisment();
                $(window).scrollTop(0);
            }
            else if(type==='category_mobile')
            {
                if(value==='')
                {
                    category=value;
                    $(".mobile-btn").removeClass('d-none');
                    $("#parent_category").addClass('d-none');
                    counter=0;
                    load_advertisment();
                    $(window).scrollTop(0);

                }
                else if(category!==value)
                {
                    category=value;
                    $(".mobile-btn").addClass('d-none');
                    $("#btn"+value).removeClass('d-none');
                    $("#parent_category").removeClass('d-none');
                    counter=0;
                    load_advertisment();
                    $(window).scrollTop(0);
                }
            }
            else
            {
                if(text!==value)
                {
                    text=value;
                    counter=0;
                    load_advertisment();
                    $(window).scrollTop(0);
                }
            }
            document.getElementById("key").blur();
        }

        function  load_advertisment() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'/user/advertisment/search',
                method:'post',
                data:{counter:counter,limit:limit,text:text,category:category},
                success:function (data) {
                    if(data!=='')
                    {
                        if (counter===0)
                        {
                            $('#load_data').html(data);
                        }
                        else
                        {
                            $('#load_data').append(data);
                        }
                        counter++;
                        loading=false;
                    }
                    else
                    {
                        if(counter===0)
                            $('#load_data').html('<div class="col-12 bold text-center alert alert-warning">متاسفانه نتیجه ای یافت نشد</div>');
                        loading=true;
                    }
                    document.getElementById('loading').classList.remove('d-block');
                    document.getElementById('loading').classList.add('d-none');
                }
            });
        }

        function lazyloadsearch() {
            $(window).scroll(function () {
                if ($(window).scrollTop() > oldscroll) {
                    if (($(window).scrollTop() + $(window).height() >= $(document).height()-600)) {
                        if (!loading)
                        {
                            loading=true;
                            oldscroll=$(window).scrollTop();
                            load_advertisment();
                            document.getElementById('loading').classList.remove('d-none');
                            document.getElementById('loading').classList.add('d-block');
                        }
                    }
                }
            });
        }

    </script>

@endsection
