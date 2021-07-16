@extends('user.index')

@section('title','ثبت رایگان آگهی')

@section('keywords','ثبت اگهی فروش خانه در اصفهان - ثبت اگهی اجاره خانه در اصفهان - ثبت اگهی فروش باغ در اصفهان - ثبت اگهی فروش دفتر کار در اصفهان')

@section('description',$response['app_description'])


@section('content')

    <section>
        <div class="container">
            <div class="row px-1 my-4">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 my-4 mx-2 mx-auto text-right border rounded">
                    <h1 class="bold font-iran font-size-20 text-black text-right my-4">{{$response['title']}}</h1>
                    <table class="table table-hover">
                        @foreach($response['categories'] as $category)
                            <tr>
                                <td class="font-iran">
                                    <a href="{{route('user.advertisment.add',$category->slug)}}"
                                       class="text-decoration-none font-size-15 text-black">{{$category->name}}</a>
                                </td>
                            </tr>
                        @endforeach

                    </table>

                </div>
            </div>
        </div>
    </section>

@endsection
