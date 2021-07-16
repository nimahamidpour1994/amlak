@extends('front.index')

@section('title','ورود کاربران')

@section('topnav')
    @include('front.top.navbar')
@endsection

@section('content')
    <!-- WELCOME -->
    <section class="direction-ltr main-background mt-5" id="welcome">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mt-5">
                    <div class="card">
                        <div class="bg-light-gray card-header font-size-19 bold  align-right text-center" >
                            ورود به پنل کاربری {{$response['app_name']}}
                        </div>
                        <div class="card-body">
                            @include('message.message')
                            <form action="{{route('login')}}" method="POST" class="align-right">
                                @csrf
                                <div class="form-row direction-rtl my-3">
                                    <i class="fa fa-user text-danger"></i> &nbsp;
                                    <label for="mobile-id" class="bold">نام کاربری</label>&nbsp;
                                    <div class="input-icons col-12">
                                        <input value="{{$response['mobile']}}" id="mobile-id" name="mobile" class="input-field form-control rounded p-4 fa-num text-center" type="text" placeholder="۰۹۱۲۳۴۵۶۷۸۹" readonly>
                                    </div>
                                </div>
                                <div class="form-row direction-rtl my-3">
                                    <i class="fa fa-lock text-danger"></i> &nbsp;
                                    <label for="password-id" class="bold">کد دریافتی</label>&nbsp;
                                    <div class="input-icons col-12">
                                        <input value="" id="password-id" name="password" class="input-field form-control rounded p-4 fa-num text-center" type="text" placeholder="ــ ــ ــ ــ" >
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-8 col-sm-12 col-xs-12 mx-auto mt-3">
                                    <input type="submit" class="btn btn-danger form-control btn-sm font-size-17 font-iran " value="ورود">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12 mx-auto mt-3 text-center">
                                    <a href="{{route('login')}}" class="text-decoration-none text-danger font-size-15 bold text-center">تغییر شماره تلفن همراه</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- WELCOME -->


@endsection
