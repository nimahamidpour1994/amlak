@extends('user.index')

@section('title','لیست پیام ها ')


@section('content')

    <section>
        <div class="container mt-5">

            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-xs-12 col-sm-12 mx-auto">

                    <nav>
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

                    <div class="row mx-auto">
                        <div class="table-responsive mt-5">
                            <table class="table table-bordered table-striped">
                                <tr class="fa-num text-center font-size-14">
                                    <th>شماره تماس</th>
                                    <th>عنوان آگهی</th>
                                    <th>مشاهده</th>
                                </tr>
                                @foreach($response['chats'] as $chat)
                                    <tr  class="fa-num text-center font-size-14">
                                        <td>
                                            <a class="btn text-decoration-none text-secondary fa-num font-size-14 bold" href="tel:{{$chat->first()->sender !== \Illuminate\Support\Facades\Auth::user()->mobile ? $chat->first()->sender :$chat->first()->receiver}}">
                                                {{$chat->first()->sender !== \Illuminate\Support\Facades\Auth::user()->mobile ? $chat->first()->sender :$chat->first()->receiver}}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="fa-num font-size-14 text-primary">
                                                {{$chat->first()->Advertisment->name}}
                                            </span>
                                            <span class="fa-num font-size-12 text-muted d-block mt-2">

                                                <!-- SHOW LAST MESSAGE -->
                                                {{\App\Models\Chat::orderBy('id','DESC')
                                                ->firstWhere('tracking_code',$chat->first()->tracking_code)
                                                ->message}}

                                                <!-- CHECK UNREAD MESSAGE -->
                                               @if(\App\Models\Chat::firstWhere([['tracking_code',$chat->first()->tracking_code]
                                                ,['receiver',\Illuminate\Support\Facades\Auth::user()->mobile],['read','unread']]))

                                                      <span class="text-danger font-size-14 ">(پیام جدید)</span>

                                                @endif

                                            </span>
                                        </td>

                                        <td class="fa-num">
                                            <a href="{{route('user.chat.show',$chat->first()->id)}}" class="btn btn-outline-success font-size-12 btn-sm decoration-none">
                                                مشاهده گفتگو
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>





@endsection
