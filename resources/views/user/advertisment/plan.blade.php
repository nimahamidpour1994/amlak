@extends('user.index')

@section('title','ارتقا آگهی')

@section('keywords','ثبت اگهی فروش خانه در اصفهان - ثبت اگهی اجاره خانه در اصفهان - ثبت اگهی فروش باغ در اصفهان - ثبت اگهی فروش دفتر کار در اصفهان')

@section('description',$response['app_description'])

@section('content')


    <!-- MANAGE ADVERTISMENT -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12  ">
                <h2 class="text-right font-iran bold font-size-11rem">مدیریت آگهی
                    @if($response['advertisment']->created_at > \Carbon\Carbon::now()->subDays($response['expire_day']))
                        @if($response['advertisment']->show === 'waiting')
                            <span class="font-iran bold text-orange font-size-14 bold">({{$response['advertisment']->Status->unique}})</span>
                            &nbsp;
                        @elseif($response['advertisment']->show ==='success')
                            <span class="font-iran bold text-success font-size-14 bold">({{$response['advertisment']->Status->unique}})</span>
                            &nbsp;
                        @else
                            <span class="font-iran bold text-danger font-size-14 bold">({{$response['advertisment']->Status->unique}})</span>&nbsp;
                        @endif
                    @else
                        <span class="font-iran bold text-danger font-size-14 bold">(منقضی شده)</span>&nbsp;
                    @endif
                </h2>
            </div>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-sm-12 mx-aut ">

                        <nav>
                            <div class="d-flex flex-nowrap  nav nav-tabs nav-fill " id="nav-tab" role="tablist">
                                <a class="nav-item nav-link  border-none font-size-14 text-dark"
                                   href="{{route('user.advertisment.preview',$response['advertisment']->slug)}}">پیش نمایش
                                    آگهی</a>
                                <a class="nav-item nav-link border-none font-size-14 active"
                                   href="{{route('user.order.create',$response['advertisment']->slug)}}">ارتقا</a>
                                <a class="nav-item nav-link border-none font-size-14  text-dark"
                                   href="{{route('user.advertisment.edit',$response['advertisment']->slug)}}">ویرایش</a>
                                <a class="nav-item nav-link border-none font-size-14 text-dark  "
                                   href="{{route('user.chat.list',$response['advertisment']->slug)}}">لیست پیام ها</a></div>
                        </nav>

                        <section class="page-section">
                            <div class="row mx-auto">

                                <form class="col-12" action="{{route('user.order.store',$response['advertisment']->slug)}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-12">


                                                    @foreach($response['plans'] as $plan)

                                                        @if(($plan->key === 'extension' && $response['advertisment']->created_at > \Carbon\Carbon::now()->subDays($plan->expire)))
                                                            <div class="promote-item" style="opacity:0.8" >
                                                                <div class="promote-item__checkbox-box">
                                                                    <div class="kt-switch">
                                                                        <div class="kt-switch__cell" role="checkbox"
                                                                             aria-checked="false" tabindex="0">
                                                                            <input
                                                                                class="form-control shadow-none bg-danger"
                                                                                disabled value="{{$plan->key}}"
                                                                                name="{{$plan->key}}"
                                                                                id="{{$plan->key}}"
                                                                                onclick="shopping_cart(this,{{$plan->price}})"
                                                                                type="checkbox">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="promote-item__main">
                                                                    <div class="promote-item__heading">
                                                                        <label
                                                                            class="font-size-14 bold cursor-pointer text-muted">
                                                                            {{$plan->title}}
                                                                            <span class="fa-num bold text-danger font-size-12 bold">
                                                                                (غیر فعال)
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="promote-item__price">
                                                                        <label
                                                                            class="fa-num font-size-14 bold cursor-pointer text-muted">
                                                                            {{number_format($plan->price).' تومان '}}
                                                                        </label>
                                                                    </div>
                                                                    <div class="promote-item__desc">
                                                                        <label
                                                                            class="font-size-14 cursor-pointer">{{$plan->description}}</label>
                                                                        <span class="fa-num bold text-danger mt-3 font-size-12 bold direction-rtl d-block">
                                                                                   انقضا آگهی  : {{jdate($response['advertisment']->created_at->addDays(\App\Models\Plan::firstWhere('key','extension')->expire))->format('Y.m.d')}}
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="promote-item">
                                                                <div class="promote-item__checkbox-box">
                                                                    <div class="kt-switch">
                                                                        <div class="kt-switch__cell" role="checkbox"
                                                                             aria-checked="false" tabindex="0">
                                                                            <input class="form-control shadow-none bg-danger" value="{{$plan->key}}" name="{{$plan->key}}" id="{{$plan->key}}" onclick="shopping_cart(this,{{$plan->price}})"
                                                                                   type="checkbox">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="promote-item__main">
                                                                    <div class="promote-item__heading">
                                                                        <label for="{{$plan->key}}" class="font-size-14 bold cursor-pointer">{{$plan->title}}</label>
                                                                    </div>
                                                                    <div class="promote-item__price">
                                                                        <label for="{{$plan->key}}" class="fa-num font-size-14 bold cursor-pointer">
                                                                            {{number_format($plan->price).' تومان '}}
                                                                        </label>
                                                                    </div>
                                                                    <div class="promote-item__desc">
                                                                        <label for="{{$plan->key}}" class="font-size-14 cursor-pointer">{{$plan->description}}</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 px-5">
                                            <div class="row p-4 rem25-border" style="border: solid 1px #ccc!important;">
                                                <div class="col-12 font-size-14 text-dark font-iran align-center">
                                                    جمع مبلغ قابل پرداخت
                                                </div>
                                                <div class="col-12 font-size-14 bold text-divar fa-num align-center my-3" id="show_price">
                                                    0 ریال
                                                </div>
                                                <div class="col-12 d-flex justify-content-center my-3">
                                                    <input type="submit" value="پرداخت از طریق کارت های شتاب" id="shopping_submit" disabled
                                                           class="font-iran btn font-size-14 btn-deactive">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </section>
                </div>
            </div>
        </div>
    </section>



@endsection


@section('script')
    <script>
        var sum=0;
        function shopping_cart(parent,price) {

            if(parent.checked === true)
                sum+=price;
            else
                sum-=price;

            if(sum > 0)
            {
                document.getElementById('shopping_submit').disabled=false;
                $('#shopping_submit').addClass('btn-active').removeClass('btn-deactive');
            }
            else
            {
                document.getElementById('shopping_submit').disabled=true;
                $('#shopping_submit').addClass('btn-deactive').removeClass('btn-active');
            }

            var value=sum.toString();
            var output = "";
            try {
                value = value.replace(/[^0-9]/g, ""); // remove all chars including spaces, except digits.
                var totalSize = value.length;
                for (var i = totalSize - 1; i > -1; i--) {
                    output = value.charAt(i) + output;
                    var cnt = totalSize - i;
                    if (cnt % 3 === 0 && i !== 0) {
                        output = "," + output; // seperator is " "
                    }
                }
            } catch (err) {
                output = value; // it won't happen, but it's sweet to catch exceptions.
            }
            document.getElementById('show_price').innerHTML = output + ' '+ 'تومان';
        }
    </script>
@endsection
