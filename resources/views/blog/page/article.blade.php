@extends('blog.index')

@section('canonical','/blog/article/'.$response['blog']->title)

@section('ogtag')
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="'/blog/article/{{$response['blog']->slug}}"/>
    <meta property="og:article:published_time" content="{{$response['blog']->created_at}}"/>
    <meta property="og:article:modified_time" content="{{$response['blog']->updated_at}}"/>
    <meta property="og:article:section" content="{{$response['app_issue']}}"/>
    <meta property="og:article:tag" content="{{$response['blog']->title}}"/>
@endsection

@section('title',isset($response['meta']['title']) ?
            $response['meta']['title'] : $response['blog']->title.' '.$response['app_issue'])

@section('keywords',isset($response['meta']['keyword']) ?
            $response['meta']['keyword'] : $response['blog']->title.' '.$response['app_issue'])

@section('description',isset($response['meta']['description']) ?
            $response['meta']['description'] : $response['blog']->title.' '.$response['app_issue'])

@section('content')
    <section class="page-section direction-rtl p-0">
        <div class="container bg-white pt-5">
            <div class="row">

                <!-- RIGHT SIDE -->
                <div class="col-lg-8 col-md-8 col-md-12 col-sm-12 col-xs-12 text-center p-4" >

                    <!-- MAIN BLOG -->
                    <div class="row direction-rtl mb-4">
                        <div class="card border-none mb-4">
                            <div class="row no-gutters">
                                <h1  class="card-title font-size-20 font-yekan text-black mb-4">{{$response['blog']->title}}</h1>

                                <img src="{{url($response['blog']->thumbnail)}}" class="card-img-top article-img" alt="{{$response['blog']->title}}">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card-body text-justify line-35">
                                        {!! $response['blog']->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MAIN BLOG -->

                    <!-- RELEATED ARTICLES -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <p class="font-weight-bold font-yekan border-bottom-red text-right" >  مقالات  مرتبط </p>
                            <div class="row">
                                @foreach($response['latest_content'] as $most_visited)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                        <div class="card border-none mx-auto pt-2" >
                                            <a class="text-black text-decoration-none cursor-pointer blog-hover" href="{{route('app.blog.show',$most_visited->slug)}}">
                                                <img class="card-img-top rounded" style="height: 195px!important;" src="{{url($most_visited->thumbnail)}}" alt="{{$most_visited->title}}">
                                                <div class="card-body px-0">
                                                    <h2 class="card-title font-size-15 font-yekan text-right">{{$most_visited->title}}</h2>
                                                    <div class="text-right font-size-11 text-secondary fa-num mb-3">
                                                        {{jdate($most_visited->created_at)->format('Y.m.d')}}
                                                        <span class="view-counter  fa-num">{{$most_visited->views}}</span>
                                                    </div>
                                                    <div class="card-text font-size-12 text-muted text-right">
                                                        {!! mb_substr(strip_tags($most_visited->content),0,200,'UTF8') !!}
                                                    </div>

                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- RELEATED ARTICLES -->


                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <p class="font-weight-bold font-yekan border-bottom-red text-right pb-2">  نظرات کاربران </p>

                                @foreach($response['comments'] as $comment)
                                    <div class="row border-bottom mt-3">
                                        <div class="col-12 text-right">
                                            <i class="fas fa-user fa-2x text-divar"></i> &nbsp;
                                            <span class="font-yekan font-size-14 text-dark font-weight-bold"> {{$comment->name}}</span>
                                           <div class="d-inline-block fa-num font-size-11 text-muted direction-ltr">
                                            ( {{jdate($comment->created_at)->format('Y/m/d - H:i')}} )
                                           </div>
                                        </div>
                                        <div class="col-11 my-2 text-justify font-size-14 mr-5 line-25">{!! $comment->content !!}</div>

                                        <div class="col-12 text-left">

                                            <button class="btn shadow-none" onclick="likeComment('{{$comment->id}}')">
                                                <i class="fas fa-thumbs-up text-success font-size-17"></i>
                                                <span class="fa-num font-size-14 ml-3" id="like{{$comment->id}}">{{$comment->like}}</span>
                                            </button>
                                            <button class="btn shadow-none" onclick="dislikeComment('{{$comment->id}}')">
                                                <i class="fas fa-thumbs-down text-divar font-size-17"></i>
                                                <span class="fa-num font-size-14 ml-3" id="dislike{{$comment->id}}">{{$comment->dislike}}</span>
                                            </button>

                                        </div>
                                    </div>
                                @endforeach

                            <div class="row">
                                @include('message.message')
                                <form class="col-12 text-right" action="{{route('app.comment.store')}}" method="post">
                                    @csrf
                                        <h2 class="font-yekan font-size-15 text-right font-weight-bold my-3">ارسال یک پاسخ</h2>
                                    <textarea class="form-control font-yekan text-muted font-size-12 direction-rtl text-right p-3 shadow-none @error('comment') is-invalid @enderror"
                                              name="comment"
                                              placeholder="دیدگاه : " style="height: 180px"></textarea>

                                    <input type="text" name="name"
                                           class="form-control text-right font-yekan font-size-12 mt-3 shadow-none @error('name') is-invalid @enderror"
                                           placeholder="نام : * ">

                                    <input type="email" name="email"
                                           class="form-control text-right direction-ltr font-yekan font-size-12 mt-3 shadow-none @error('email') is-invalid @enderror"
                                           placeholder="* : ایمیل ">

                                    <input type="hidden" value="{{$response['blog']->id}}" name="blog_id">
                                    <input type="submit" class="btn btn-dark font-size-12 font-yekan mt-3 text-right shadow-none" value="ارسال دیدگاه">

                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- RIGHT SIDE -->

                <!-- LEFT SIDE -->
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 text-center">
                    <h3 class="font-weight-bold font-yekan border-bottom-red font-size-15 text-black pb-2 mx-auto width-20"> آخرین مقالات</h3>
                    @foreach(  $response['latest_content'] as $most_visited)
                        <div class="card border-none mx-auto width-20 pt-2" >
                            <a class="text-black text-decoration-none cursor-pointer blog-hover" href="{{route('app.blog.show',$most_visited->slug)}}">
                                <img class="card-img-top rounded" style="height: 195px!important;" src="{{url($most_visited->thumbnail)}}" alt="{{$most_visited->title}}">
                                <div class="card-body px-0">
                                    <h2 class="card-title font-size-15 font-yekan text-right">{{$most_visited->title}}</h2>
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
                <!-- LEFT SIDE -->


            </div>
        </div>

    </section>
@endsection

