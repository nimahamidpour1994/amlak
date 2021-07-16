@extends('back.index')


@section('content')

        <div class="container">
            <div class="row mx-auto">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-sm-12 mx-auto">

                    @include('message.message')
                    <form action="{{route('admin.advertisment.update',$response['advertisment']->id)}}" method="POST"
                          class="form text-right border p-3 rounded">
                        @csrf
                        <div class="form-row">

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="parent_id" class="font-size-15 bold"><i
                                        class="fas fa-pencil-alt prefix text-right"></i>&nbsp; عنوان آگهی</label>
                                <input type="text" class="form-control font-iran" name="name" placeholder="عنوان آگهی"
                                       value="{{$response['advertisment']->name}}">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="parent_id" class="font-size-15 bold"><i
                                        class="fas fa-pencil-alt prefix text-right"></i>&nbsp; شماره موبایل</label>
                                <input class="form-control fa-num direction-ltr" type="number" placeholder="09**"
                                       name="mobile" value="{{$response['advertisment']->mobile}}" readonly>
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="parent_id" class="font-size-15 bold"><i
                                        class="fas fa-pencil-alt prefix text-right"></i>&nbsp; توضیحات آگهی</label>
                                <textarea class="form-control font-iran p-2" name="details"
                                          placeholder="توضیحات">{{$response['advertisment']->details}}</textarea>
                            </div>
                        </div>

                        <div class="form-row mb-5 border-bottom border-danger py-5">
                            <div class="align-right mr-2">
                                <div class="image-upload">
                                    <label for="photo">
                                        <span class="bold">عکس آگهی </span>
                                        <br/>
                                        <span class="font-size-12">
                                              افزودنِ عکس بازدید آگهی شما را تا سه برابر افزایش می‌دهد.
                                         </span>
                                    </label>
                                    <div class="d-block" id="preview-img">
                                        @if($response['advertisment']->icon)
                                            <img
                                                src="{{url('storage/advertisment/thumbnail/'.$response['advertisment']->icon)}}"
                                                style="height: 100px;width: 100px;"
                                                class="rounded img-thumbnail" onmouseenter="showdeleteimg(this)"
                                                onmouseout="showthisimg(this,'{{$response['advertisment']->icon}}')"
                                                onclick="deleteimg(this,'{{$response['advertisment']->icon}}')">
                                            @foreach($response['images'] as $image)
                                                <img
                                                    src="{{url('storage/advertisment/thumbnail/'.$image->value)}}"
                                                    style="height: 100px;width: 100px;"
                                                    class="rounded img-thumbnail" onmouseenter="showdeleteimg(this)"
                                                    onmouseout="showthisimg(this,'{{$image->value}}')"
                                                    onclick="deleteimg(this,'{{$image->value}}')">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row mt-3">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="messageAdmin" class="font-size-15 text-danger bold"><i
                                        class="fas fa-pencil-alt prefix text-right"></i>&nbsp; وضعیت آگهی</label>
                                <div class="direction-rtl">
                                   @foreach($response['status'] as $status)
                                        <input class="m-3" type="radio" name="status" id="status{{$status->value}}" value="{{$status->value}}" {{$status->value == $response['advertisment']->show ? 'checked' : ''}}>
                                        <label class="font-size-15 bold" for="status{{$status->value}}">{{$status->unique}}</label>
                                    @endforeach
                                  </div>
                             </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="messageAdmin" class="font-size-15 text-danger  bold"><i
                                        class="fas fa-pencil-alt prefix text-right"></i>&nbsp; علت رد آگهی</label>
                                <textarea class="form-control font-iran p-2" name="messageAdmin" id="messageAdmin"
                                          placeholder="علت رد آگهی">{{$response['advertisment']->messageAdmin}}</textarea>
                            </div>
                        </div>


                        <div class="form-row my-4">
                            <input type="submit" class="btn btn-success bg-admin mx-auto fa-num" style="width: 200px!important;"
                                   value="ذخیره کردن تغییرات">
                        </div>

                    </form>

                </div>
            </div>
        </div>

@endsection
