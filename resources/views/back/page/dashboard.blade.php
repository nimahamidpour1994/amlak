@extends('back.index')


@section('content')

    <!-- Icon Cards-->
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                <a class="text-decoration-none" href="{{route('admin.advertisment.list','waiting')}}">
                    <div class="card text-white bg-info o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-comments"></i>
                            </div>
                            <div class="text-center bold">آگـــــهی های در حال انتشار</div>
                        </div>
                        <div class="card-footer  clearfix  z-1 text-center static-answer fa-num  bold font-size-20" id="count_category_id">
                            {{$response['waitingaddvertisments']}}
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                <a class="text-decoration-none" href="{{route('admin.advertisment.list','publish')}}">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-comments"></i>
                            </div>
                            <div class="text-center bold">آگـــــهی های منتشر شده</div>
                        </div>
                        <div class="card-footer clearfix  z-1 text-center static-answer fa-num  bold font-size-20" id="count_product_id">
                            {{$response['successaddvertisments']}}
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                <a class="text-decoration-none" href="{{route('admin.advertisment.list','faild')}}">
                    <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-comments"></i>
                            </div>
                            <div class="text-center bold">آگـــــهی های رد شده</div>
                        </div>
                        <div class="card-footer clearfix  z-1 text-center static-answer fa-num  bold font-size-20" id="count_product_id">
                            {{$response['faildaddvertisments']}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
