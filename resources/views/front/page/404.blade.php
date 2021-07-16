@extends('front.index')
@section('title','موردی یافت نشد')

@section('content')

    <!-- MAIN CODE -->
    <section>
        <div class="container-fluid mt-lg-4 mt-3">

            <div class="row">
                <div class="col-12 text-center">
                    <img src="{{url('front/img/structure/404.png')}}" style="height: 300px;margin-top: 50px">
                    <p class="font-yekan font-size-28 mt-5 font-weight-bold">این راه به جایی نمیرسد!</p>
                    <p class="font-yekan font-size-17 my-4">به نظر آدرس را اشتباه وارد کرده‌اید.</p>
                    <p class="font-yekan font-size-17 my-4">برای پیدا کردن مسیر درست می‌توانید سری به  <a class="text-decoration-none text-divar font-weight-bold" href="{{route('app.home')}}">صفحه اول</a> بزنید</p>
                </div>
            </div>
        </div>
    </section>
@endsection
