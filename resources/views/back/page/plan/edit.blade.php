@extends('back.index')

@section('content')

    <section class="direction-ltr bg-white pt-0">

        <div class="container-fluid my-5">
            @include('message.message')
            <form  action="{{route('admin.plan.update',$response['plan']->id)}}"
                   method="POST" class="form admin-form">
                @csrf

                <div class="form-row mt-3">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="title_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;عنوان طرح</label>
                        <input type="text" class="form-control admin-input  @error('title') is-invalid @enderror"
                               id="title_id" name="title" placeholder="عنوان طرح"
                               value="{{$response['plan']->title !='' ? $response['plan']->title : ''}}">
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="price_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp; قیمت </label>
                        <input type="text" class="form-control admin-input @error('price') is-invalid @enderror"
                               id="price_id" name="price" placeholder="قیمت"
                               value="{{$response['plan']->price!='' ? $response['plan']->price : ''}}">
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="expire_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;مدت انقضا</label>
                        <input type="text" class="form-control admin-input @error('expire') is-invalid @enderror"
                               id="expire_id" name="expire" placeholder="مدت انقضا"
                               value="{{$response['plan']->expire!='' ? $response['plan']->expire : ''}}">
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="description_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;توضیحات</label>
                        <textarea class="form-control p-3 admin-input @error('description') is-invalid @enderror" id="description_id"
                                  name="description" placeholder="آدرس"
                                  style="height: 75px">{{$response['plan']->description !='' ? $response['plan']->description : ''}}</textarea>
                    </div>
                </div>

                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ویرایش" >

                </div>

            </form>
        </div>
    </section>


@endsection


