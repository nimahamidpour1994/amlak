@extends('blog.index')

@section('title','صفحه اصلی')

@section('keyword','')

@section('description','')

@section('content')

    <section class="page-section direction-rtl p-0">
        <div class="container bg-white pt-5">
            <div class="row">

                <!-- LAST UPLOAD -->
                <div class="col-lg-8 col-md-8 col-md-12 col-sm-12 col-xs-12 text-center">

                    <div class="text-right mb-3">
                        <span class="text-dark font-size-17">نتایج جستجو برای : </span>
                        <span class="text-divar font-size-15">{{$response['search']}} </span>
                    </div>
                    <form action="{{route('app.blog.search')}}" method="post">
                        @csrf
                        <div class="input-group">
                             <input type="text" style="height: 34px!important;"
                                   class="form-control text-right fa-num font-size-12
                                       shadow-none direction-rtl text-black rounded-0" autocomplete="off"
                                   onkeyup="suggest_search_blog()" id="search_text_id" name="search_text_name">
                            <input type="submit" class="btn bg-black font-yekan text-white rounded-0
                                            px-3 text-center border-none" style="height: 35px!important" value="جستجو" onclick="search()">

                        </div>

                        <div class="border-top mt-3 direction-rtl text-center" id="aj_search_content">

                        </div>

                    </form>

                    <div class="row direction-rtl mb-4 mt-2">

                        @if(isset($response['blogs'] ) && count($response['blogs']) > 0)
                             @foreach($response['blogs'] as $latest_content)
                            <div class="card border-none my-2">
                                <a class="w-100 d-content text-decoration-none cursor-pointer blog-hover"  href="{{route('app.blog.show',$latest_content->slug)}}">
                                    <div class="row no-gutters">
                                        <!-- IMG -->
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4 pr-2">
                                            <img src="{{url($latest_content->thumbnail)}}" style="height: 195px!important;" class="card-img height-100" alt="{{$latest_content->title}}">
                                        </div>

                                        <!-- TEXT -->
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <div class="card-body">
                                                <h2 class="card-title text-right font-size-15 font-yekan bold text-black">{{$latest_content->title}}</h2>
                                                <div class="col-12 text-right my-2 mx-0 px-0">
                                                    <a class="blog-category-link font-yekan" href="{{route('app.blog',$latest_content->Category->slug)}}">
                                                        {{$latest_content->Category->name}}
                                                    </a>
                                                    <span class="card-title text-right font-size-11 text-secondary fa-num mr-1">
                                                             {{jdate($latest_content->created_at)->format('Y.m.d')}}
                                                     </span>
                                                    <span class="view-counter fa-num">{{$latest_content->views}}</span>
                                                </div>
                                                <div class="card-text text-justify text-muted font-yekan mt-3 font-size-14">
                                                    {!! mb_substr(strip_tags($latest_content->content),0,200,'UTF8').'...' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        @else
                            <div class="col-11 mx-2 my-5 alert alert-warning text-center font-size-14 font-yekan">
                                متاسفانه موردی یافت نشد
                            </div>
                        @endif

                    </div>
                </div>

                <!-- MOST VIEW -->
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 text-center p-2">
                    <h3 class="bold border-bottom-red font-size-15 text-black pb-2 mx-auto width-20"> پربازدید ترین مقالات </h3>
                    @foreach($response['most_visited'] as $most_visited)
                    <div class="card border-none mx-auto width-20 pt-2">
                        <a class="text-decoration-none cursor-pointer blog-hover"  href="{{route('app.blog.show',$most_visited->slug)}}">
                        <img class="card-img-top rounded" style="height: 195px!important;" src="{{$most_visited->thumbnail}}" alt="{{$most_visited->title}}">
                        <div class="card-body px-0">
                            <h2 class="card-title font-size-15 text-right font-yekan text-dark">{{$most_visited->title}}</h2>
                            <div class="text-right font-size-11 text-secondary fa-num mb-2">
                                 {{jdate($most_visited->created_at)->format('Y.m.d')}}
                                <span class="view-counter fa-num">{{$most_visited->views}}</span>
                             </div>
                            <div class="card-text font-size-12 text-muted text-right">
                                {!! mb_substr(strip_tags($most_visited->content),0,200,'UTF8') !!}
                            </div>

                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

@endsection


