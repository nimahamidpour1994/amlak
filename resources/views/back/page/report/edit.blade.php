@extends('back.index')


@section('content')

    <section class="direction-ltr bg-white pt-0" id="welcome">
        <div class="container-fluid my-5">
            @include('message.message')
            <form  action="{{route('admin.report.update',$response['report']->id)}}" enctype="multipart/form-data"
                   method="POST" class="form admin-form">
                @csrf



                <div class="form-row mt-3">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="title_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;مشکل آگهی</label>
                        <input type="text" class="form-control admin-input  @error('title') is-invalid @enderror"
                               id="title_id" name="title" placeholder="مشکل آگهی" readonly
                               value="{{$response['report']->category !='' ? $response['report']->category : ''}}">
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="issue_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;موبایل</label>
                        <input type="text" class="form-control admin-input  @error('issue') is-invalid @enderror"
                               id="issue_id" name="issue" placeholder="موبایل" readonly
                               value="{{$response['report']->mobile !='' ? $response['report']->mobile : ''}}">
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="issue_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;توضیحات بیشتر	</label>
                        <input type="text" class="form-control admin-input  @error('issue') is-invalid @enderror"
                               id="issue_id" name="issue" placeholder="توضیحات بیشتر" readonly
                               value="{{$response['report']->message !='' ? $response['report']->message: ''}}">
                    </div>

                </div>


                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="result" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp; توضیحات مدیر </label>
                        <textarea class="form-control admin-input p-2" id="result"
                                  name="result" placeholder="توضیحات مدیر">{{$response['report']->result !='' ? $response['report']->result: ''}}</textarea>
                    </div>
                </div>


                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ویرایش">
                </div>

            </form>
        </div>
    </section>


@endsection


