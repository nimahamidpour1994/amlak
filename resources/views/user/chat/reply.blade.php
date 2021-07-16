@extends('user.index')

@section('title',' مشاهده پیام ها ')

@section('content')

    <section>
        <div class="container direction-ltr bg-white mt-5">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12 mx-auto">
                    <nav class="direction-rtl mb-5">
                        <div class="d-flex flex-nowrap  nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link  border-none font-size-14  text-dark"
                               href="{{route('user.dashboard')}}">
                                آگهی های من
                            </a>
                            <a class="nav-item nav-link border-none active font-size-14"
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


                    <h2 class="font-iran font-size-17 bold text-divar text-danger mx-auto mb-3">{{ $response['advertisment_name']}}</h2>
                       @foreach($response['chats'] as $chat)
                             <div class="row px-3">
                                <div class="col-12 pt-3 text-right border rounded mt-2
                                  {{$chat->sender ===\Illuminate\Support\Facades\Auth::user()->mobile ? 'bg-light' : 'bg-light-pink'}}">

                                    <div class="d-inline-block">
                                        <span class="fa-num font-size-12 bold  {{$chat->sender === \Illuminate\Support\Facades\Auth::user()->mobile ? 'text-primary' : 'text-danger'}}">
                                            {{$chat->sender === \Illuminate\Support\Facades\Auth::user()->mobile ? 'شما' : $chat->sender}}
                                        </span>
                                    </div>
                                    <div class="d-inline-block float-left fa-num font-size-12 bold text-dark text-center">
                                        {{jdate($chat->created_at)->format('Y.m.d - H:i')}}
                                    </div>
                                    <hr/>
                                    <p class="font-yekan font-size-14 line-35 text-right {{$chat->sender === \Illuminate\Support\Facades\Auth::user()->mobile ? 'text-black' : 'text-muted'}}">
                                        {!! str_replace(PHP_EOL,"<br/>",$chat->message) !!}
                                    </p>
                                </div>
                        </div>
                        @endforeach


                    <section class="page-section direction-ltr bg-white pt-0 border-top my-4">
                        <div class="container my-3">
                            @include('message.message')
                            <form action="{{route('user.chat.reply')}}" method="POST"
                                  class="form text-right">
                                @csrf
                                <input type="hidden" value="{{$response['advertisment_id']}}" name="parent">
                                <input type="hidden" value="{{$response['other_side']}}" name="other_side">
                                <div class="form-row mt-3">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <label for="message" class="font-iran font-size-12 bold text-black direction-rtl">
                                            <i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;پیام جدید</label>
                                        <textarea class="form-control font-iran font-size-14 text-muted shadow-none text-right p-3 direction-rtl" style="height: 100px" id="message" name="message" placeholder="پیام ...">{{old('message')}}</textarea>
                                    </div>
                                </div>


                                <div class="form-row mt-5">
                                    <input type="submit" class="btn col-xl-3 col-lg-3 col-md-8 col-sm-12 col-xs-12 btn bg-divar text-white mx-auto font-iran font-size-14" value="ارســال" >
                                </div>


                            </form>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </section>

@endsection




