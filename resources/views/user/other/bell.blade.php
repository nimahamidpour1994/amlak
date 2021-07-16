@extends('user.index')

@section('title','لیست گوش به زنگ  ')
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
                            <a class="nav-item nav-link border-none font-size-1rem text-dark"
                               href="{{route('user.bookmarks')}}">
                                آگهی های نشان شده
                            </a>
                            <a class="nav-item nav-link border-none font-size-1rem text-dark"
                               href="{{route('user.recentseen')}}">
                                بازدیدهای اخیر
                            </a>
                            <a class="nav-item nav-link border-none font-size-1rem  active"
                               href="{{route('user.bell.list')}}">
                                لیست گوش به زنگ
                            </a>
                        </div>
                    </nav>

                    <div class="row mt-3">
                        <table class="table table-hover table-bordered text-center">
                            <tr>
                                <th>ردیف</th>
                                <th>دسته بندی</th>
                                <th>منطقه</th>
                                <th>آگهی دهنده</th>
                                <th>تاریخ</th>
                                <th>حذف</th>
                            </tr>
                            @foreach($response['bells'] as $row => $bell)
                                <tr>
                                    <td  class="fa-num font-size-14">{{++$row}}</td>
                                    <td  class="font-size-14">{{$bell->Category->name}}</td>
                                    <td  class="font-size-14">{{$bell->State->name}}</td>
                                    <td class="font-size-14">
                                        @switch($bell->who)
                                            @case('person')
                                               شخصی
                                            @break
                                            @case('agent')
                                                مشاور املاک
                                            @break
                                            @default
                                                مشاور املاک / شخصی
                                        @endswitch
                                    </td>
                                    <td class="fa-num direction-ltr font-size-14">{{jdate($bell->created_at)->format('Y / m / d')}}</td>
                                    <td>
                                        <a href="{{route('user.bell.destroy',$bell->id)}}" class="btn btn-danger btn-sm">
                                            حذف
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
