@extends('user.index')

@section('title','آگهی های نشان شده  ')
@section('description','')

@section('content')
    <section>
        <div class="container mt-5">

            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-xs-12 col-sm-12 mx-auto">

                    <nav>
                        <div class="d-flex flex-nowrap  nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link  border-none font-size-1rem text-dark"
                               href="{{route('user.dashboard')}}">
                                آگهی های من
                            </a>
                            <a class="nav-item nav-link border-none font-size-14 text-dark"
                               href="{{route('user.chat.list')}}">
                               لیست پیام ها
                            </a>
                            <a class="nav-item nav-link border-none font-size-1rem active"
                               href="{{route('user.bookmarks')}}">
                                آگهی های نشان شده
                            </a>
                            <a class="nav-item nav-link border-none font-size-1rem text-dark"
                               href="{{route('user.recentseen')}}">
                                بازدیدهای اخیر
                            </a>
                            <a class="nav-item nav-link border-none font-size-1rem text-dark"
                               href="{{route('user.bell.list')}}">
                                لیست گوش به زنگ
                            </a>
                        </div>
                    </nav>

                    <div class="row mt-3">
                        @foreach($response['advertisments'] as $advertisment)
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 my-4">
                                <a href="{{route('app.show.advertisment',$advertisment->Advertisment->slug)}}" class="text-decoration-none">
                                    <div class="border-none border-bottom-1 card single-card">
                                        <div class="row no-gutters">
                                            <div class="col-6">
                                                <span class="bg-divar text-white rounded btn-sm position-absolute fa-num font-size-12 m-2 bold">کد :  {{$advertisment->Advertisment->id}}</span>
                                                <img src="{{url($advertisment->Advertisment->icon !='' ? 'storage/advertisment/thumbnail/'.$advertisment->Advertisment->icon : 'front/img/structure/'.\App\Models\Setting::firstWhere('key','defualt-img')->value)}}" class="img-cadr-main"  alt="{{$advertisment->name}}">
                                            </div>
                                            <div class="col-6 min-100">
                                                <div class="card-body p-0">
                                                    <h2 class="d-flex flex-row-reverse card-title mb-1 align-right card-title-style text-black font-size-15 fa-num" style="min-height: 72px!important;">{{$advertisment->Advertisment->name}}</h2>

                                                    <!-- SHOW THUMBNAIL -->
                                                    <div class="text-right" style="min-height:65px">
                                                        @foreach($advertisment->Advertisment->scopeMetaKey('','field')->get() as $meta)
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

                                                    <!-- URGENT AND DATE AND STATE -->
                                                    <div class="d-flex flex-column  mb-1 direction-rtl">
                                                        <div class="d-flex flex-row">
                                                            <!-- urgent advertisments -->
                                                            @if(\App\Models\OrderDetail::firstwhere([['advertisment',$advertisment->Advertisment->id],['pay','paid'],
                                                                ['plan','urgent'],['created_at','>',\Carbon\Carbon::now()->subDays(optional(\App\Models\Plan::where('key','urgent')->first())->expire)]]))
                                                                <p class="card-text card-text-style">
                                                                    <span class="border border-danger rounded btn-fory mx-1 px-1 text-danger font-iran font-size-12 bold">فوری</span>
                                                                    <small class="text-muted fa-num">
                                                                        در {{$advertisment->Advertisment->State->name}}</small>
                                                                </p>
                                                            @else
                                                                <p class="card-text card-text-style text-right">
                                                                    <small class="text-muted fa-num font-size-12">
                                                                        @if(strlen($advertisment->Advertisment->updated_at->diffForHumans().' در '.$advertisment->Advertisment->State->name) > 25)
                                                                            {{mb_substr(strip_tags($advertisment->Advertisment->updated_at->diffForHumans().' در '.$advertisment->Advertisment->State->name),0,22,'UTF8').'...'}}
                                                                        @else
                                                                            {{$advertisment->Advertisment->updated_at->diffForHumans().' در '.$advertisment->Advertisment->State->name}}
                                                                        @endif
                                                                    </small>
                                                                </p>

                                                        @endif
                                                        <!-- urgent advertisments -->
                                                        </div>
                                                    </div>
                                                    <!-- URGENT AND DATE AND STATE -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="card-footer bg-transparent border-muted align-right p-2">
                                    <a href="{{route('user.bookmark.destroy',$advertisment->id)}}" class="btn btn-secondary btn-sm font-iran text-decoration-none">
                                        حذف از تاریخچه
                                        <img src="{{url('front/img/structure/delete.svg')}}" class="height20-width20" alt=""/>
                                    </a>
                                </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
