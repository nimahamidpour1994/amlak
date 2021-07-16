@extends('user.index')

@section('title','ویرایش آگهی')

@section('keywords','ثبت اگهی فروش خانه در اصفهان - ثبت اگهی اجاره خانه در اصفهان - ثبت اگهی فروش باغ در اصفهان - ثبت اگهی فروش دفتر کار در اصفهان')

@section('description',$response['app_description'])


@section('content')

    <section>
        <!-- MANAGE AND DELETE ADVERTISMENT -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12  ">
                    <h2 class="text-right font-yekan bold font-size-14">مدیریت آگهی
                        @if($response['advertisment']->created_at > \Carbon\Carbon::now()->subDays($response['expire_day']))
                            @if($response['advertisment']->show === 'waiting')
                                <span class="ext-orange font-size-14 font-yekan">({{$response['advertisment']->Status->unique}})</span>
                                &nbsp;
                            @elseif($response['advertisment']->show ==='success')
                                <span class="text-success font-size-14 font-yekan">({{$response['advertisment']->Status->unique}})</span>
                                &nbsp;
                            @else
                                <span class="text-danger font-size-14 font-yekan">({{$response['advertisment']->Status->unique}})</span>&nbsp;
                            @endif
                        @else
                            <span class="text-danger font-size-14 font-yekan">(منقضی شده)</span>&nbsp;
                        @endif
                    </h2>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">

                    <a class="btn btn-outline-red btn-sm bold font-iran" href="#" data-toggle="modal" data-target="#logoutModal">
                        حذف آگهی
                    </a>

                </div>
            </div>
        </div>

        <!-- ADVERTISMENT INFO -->
        <section>
            <div class="container-fluid">
                <div class="row mx-auto">

                    <!-- NAVBAR -->
                    <div class="container mb-5">
                        <nav>
                            <div class="d-flex flex-nowrap  nav nav-tabs nav-fill " id="nav-tab" role="tablist">
                                <a class="nav-item nav-link  border-none font-size-14 text-dark"
                                   href="{{route('user.advertisment.preview',$response['advertisment']->slug)}}">پیش نمایش
                                    آگهی</a>
                                <a class="nav-item nav-link border-none font-size-14 text-dark"
                                   href="{{route('user.order.create',$response['advertisment']->slug)}}">ارتقا</a>
                                <a class="nav-item nav-link border-none font-size-14  active"
                                   href="{{route('user.advertisment.edit',$response['advertisment']->slug)}}">ویرایش</a>
                                <a class="nav-item nav-link border-none font-size-14 text-dark  "
                                   href="{{route('user.chat.list',$response['advertisment']->slug)}}">لیست پیام ها</a></div>
                        </nav>
                    </div>

                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12 mx-auto">

                        @include('message.message')

                        <!-- CATEGORY -->
                        <div class="border rounded py-4 px-2 text-right mx-auto">
                            <div class="col-6 text-right">
                                <span
                                    class="col-6 font-size-14 bold text-right">{{$response['advertisment']->Category->name}}</span>
                            </div>
                        </div>

                        <form action="{{route('user.advertisment.update',$response['advertisment']->id)}}" method="POST"
                              id="testform" class="form text-right border rounded p-3 my-3" enctype="multipart/form-data">
                            @csrf

                            <!-- CITY AND STATE -->
                            <div class="form-row mt-3">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="city" class="font-size-15">&nbsp; شهر</label>
                                    <select id="city" name="city" class="form-control text-right font-iran font-size-14"
                                            readonly>
                                        @foreach($response['cities'] as $city)
                                            @if(isset($city->id))
                                                <option
                                                    value="{{$city->id}}" {{$city->id===$response['advertisment']->state ? 'selected' : ''}}>{{$city->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="parent_id" class="font-size-14">&nbsp; محدودهٔ آگهی</label>
                                    <select id="state" name="state" class="form-control text-right font-iran font-size-14"
                                            onchange="set_view(this,'2',14,'map_parent')" required>
                                        <option value="" hidden>انتخاب محله</option>
                                        @foreach($response['states'] as $state)
                                            @if(isset($state->id))
                                                <option
                                                    value="{{$state->id}}" {{$state->id===$response['advertisment']->state ? 'selected' : ''}}>{{$state->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- MAP -->
                            <div class="form-row mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4" id="map_parent">
                                    <div id="map" class="col-12" style="height: 300px">

                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <input type="button" class="btn btn-danger btn-sm font-size-14 font-iran mt-3 d-none"
                                           id="deleteposition" value="حذف موقعیت"/>
                                </div>
                            </div>

                            <!-- IMAGE -->
                            <div class="form-row mb-5">
                                <div class="align-right mr-2">

                                    <!-- IMG EXPLAIN -->
                                    <div class="image-upload">
                                        <span class="font-size-15">عکس آگهی </span><br/>
                                        <span class="font-size-12 text-secondary">  افزودنِ عکس بازدید آگهی شما را تا سه برابر افزایش می‌دهد.</span>
                                        <br/><br/>
                                    </div>

                                    <!-- UPLOAD IMG -->
                                    <div class="d-flex image-uploader__zone" id="preview-img">
                                        <label for="photo" id="uploaded_file">
                                            <div class="image-uploader__dropzone" aria-disabled="false"
                                                 style="position: relative">
                                                <i class="fas fa-camera"></i>
                                                <input type="file" name="photo[]" id="photo"
                                                       accept="image/x-png,image/gif,image/jpeg" multiple
                                                       class="d-none" onchange="setimage(this)">
                                            </div>
                                        </label>
                                        @if($response['advertisment']->icon)
                                            <div class="image-item" role="button" onclick="uploadedimageclick(this)"
                                                 id="img{{$response['advertisment']->icon}}">
                                                <div class="image-item__image"
                                                     style="background-image: url('{{'http://amlakesfahan.com/storage/advertisment/thumbnail/'.$response['advertisment']->icon}}')">
                                                    <div class="image-item__delete-btn">
                                                        <i class="far fa-trash-alt font-size-20"
                                                           onclick="uploadedimagedelete('{{$response['advertisment']->icon}}')"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach($response['images'] as $image)
                                                <div class="image-item" role="button" onclick="uploadedimageclick(this)"
                                                     id="img{{$image->value}}">
                                                    <div class="image-item__image"
                                                         style="background-image: url('{{'http://amlakesfahan.com/storage/advertisment/thumbnail/'.$image->value}}')">
                                                        <div class="image-item__delete-btn">
                                                            <i class="far fa-trash-alt font-size-20"
                                                               onclick="uploadedimagedelete('{{$image->value}}')"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                </div>

                                <!-- ERROR IMG -->
                                <div class="ui message messages messages--error d-none" id="errormain">
                                    <div class="content">
                                        <ul class="list" id="errorul">
                                        </ul>
                                    </div>
                                </div>


                            </div>

                            <!-- KEY VALUE -->
                            <div class="form-row">
                                @foreach($response['fields'] as $field)

                                    @if($field->field=='text')
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                                            <label for="parent_id" class="font-size-14 text-dark">
                                                {{$field->name}}&nbsp;
                                                <span class="text-danger bold font-size-12">({{$field->unit}})</span>
                                            </label>
                                            <input type="text" class="form-control fa-num" name="field{{$field->id}}"
                                                   value="{{optional($response['metas']->firstWhere('unique',$field->id))->value}}"
                                                   required>
                                        </div>

                                    @elseif($field->field=='number')
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                                            <label for="parent_id" class="font-size-14 text-dark">
                                                {{$field->name}}&nbsp;
                                                <span class="text-danger bold font-size-12">({{$field->unit}})</span>
                                            </label>
                                            <input type="number" class="form-control fa-num" name="field{{$field->id}}"
                                                   onkeyup="digitGroup(this,'threedigitguid{{$field->id}}','{{$field->unit}}')"
                                                   value="{{optional($response['metas']->firstWhere('unique',$field->id))->value}}"
                                                   required>
                                            <div class="font-size-14 text-dark text-right fa-num p-1"
                                                 id="threedigitguid{{$field->id}}">
                                                {{optional($response['metas']->firstWhere('key_id',$field->id))->value !==null ? number_format(optional($response['metas']->firstWhere('unique',$field->id))->value). ' '.$field->unit : ''}}
                                            </div>
                                        </div>

                                    @elseif($field->field=='list')
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                                            <label for="parent_id" class="font-size-14 text-dark">
                                                {{$field->name}}
                                            </label>
                                            <select name="field{{$field->id}}" id="" class="form-control fa-num">
                                                <option value="" hidden></option>
                                                @foreach($options=explode('-',$field->value) as $option)
                                                    <option value="{{$option}}" class="fa-num font-size-14"
                                                        {{optional($response['metas']->firstWhere('unique',$field->id))->value === $option ? 'selected' : ''}}>{{$option}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @elseif($field->field=='radio')
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3 d-inline-block">
                                            <label for="parent_id" class="font-size-14 text-dark">
                                                {{$field->name}}
                                            </label>
                                            <div class="row">
                                                <div class="col-12 direction-rtl p-2">
                                                    <table
                                                        class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                                        <tr class="border-none">
                                                            @foreach($options=explode('-',$field->value) as $option)
                                                                <td class="border-none direction-ltr text-right">
                                                                    <label for="radio{{$field->id}}{{$option}}"
                                                                           class="font-size-14">{{$option}}</label>
                                                                    <input type="radio" value="{{$option}}"
                                                                           name="field{{$field->id}}"
                                                                           id="radio{{$field->id}}{{$option}}"
                                                                           class="mx-1 fa-num font-size-15"
                                                                        {{optional($response['metas']->firstWhere('unique',$field->id))->value === $option ? 'checked' : ''}}>
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($field->field=='checkbox')
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3 d-inline-block">

                                            @if(count(explode('-',$field->value))==1)
                                                <input type="checkbox" name="field{{$field->id}}"
                                                       id="checkbox{{$field->id}}{{$field->value}}"
                                                       value="{{$field->value}}" class="mx-2" style="transform: scale(1.0);float: right!important;"
                                                    {{optional($response['metas']->firstWhere('unique',$field->id))->value === $field->value ? 'checked' : ''}}>

                                                <label for="checkbox{{$field->id}}{{$field->value}}"
                                                       class="font-size-14 text-dark">
                                                    {{$field->name}}
                                                </label>

                                            @else
                                                <label for="parent_id" class="font-size-14 text-dark">
                                                    {{$field->name}}
                                                </label>
                                                <div class="row">
                                                    <div class="col-12 direction-rtl p-2">
                                                        <table
                                                            class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                                            <tr class="border-none">
                                                                @foreach($options=explode('-',$field->value) as $option)
                                                                    <td class="border-none direction-ltr text-right">
                                                                        <label for="checkbox{{$field->id}}{{$option}}"
                                                                               class="font-size-14">{{$option}}</label>

                                                                        <input type="checkbox" value="{{$option}}"
                                                                               name="field{{$field->id}}[]"
                                                                               id="checkbox{{$field->id}}{{$option}}"
                                                                               style="transform: scale(1.0);"
                                                                            {{optional($response['metas']->firstWhere('unique',$field->id))->value === $option ? 'checked' : ''}}>

                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- PERSONAL OR AGENT -->
                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                                    <label for="parent_id" class="font-size-14 text-dark">
                                        آگهی‌دهنده
                                    </label>
                                    <table
                                        class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                        <tbody>
                                        <tr class="border-none">
                                            <td class="border-none direction-ltr text-right">
                                                <label for="person_id" class="font-size-14">شخصی</label>
                                                <input type="radio" value="person" name="who" id="person_id"
                                                       class="mx-1 fa-num font-size-15" onclick="show_more_field('person')"
                                                    {{$response['advertisment']->who==='person' ? 'checked' : ''}}>
                                            </td>
                                            <td class="border-none direction-ltr text-right">
                                                <label for="agent_id" class="font-size-14">مشاور املاک</label>
                                                <input type="radio" value="agent" name="who" id="agent_id"
                                                       class="mx-1 fa-num font-size-15" onclick="show_more_field('agent')"
                                                    {{$response['advertisment']->who==='agent' ? 'checked' : ''}}>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- MOBILE -->
                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="parent_id" class="font-size-15">&nbsp; شماره موبایل</label>
                                    <input class="form-control fa-num direction-ltr" type="number" placeholder="09**"
                                           name="mobile" value="{{Auth()->user()->mobile}}" readonly>
                                </div>
                            </div>

                            <!-- HIDEN MAP -->
                            <input type="text" hidden readonly name="lat" id="lat"
                                   value="{{$response['advertisment']->latitude}}">
                            <input type="text" hidden readonly name="lng" id="lng"
                                   value="{{$response['advertisment']->longitude}}">


                            <!-- NAME AND DESCRIPTION -->
                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="parent_id" class="font-size-15">&nbsp; عنوان آگهی</label>
                                    <br/>
                                    <span class="font-size-12 text-secondary"> در عنوان آگهی به موارد مهم و چشمگیر اشاره کنید.</span>
                                    <br/><br/>
                                    <input type="text" class="form-control font-iran font-size-14" name="name"
                                           value="{{$response['advertisment']->name}}">
                                </div>
                            </div>

                            <div class="form-row mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="parent_id" class="font-size-15">&nbsp; توضیحات آگهی</label>
                                    <br/>
                                    <span class="font-size-12 text-secondary">جزئیات و نکات قابل توجه آگهی خود را کامل و دقیق بنویسید. درج شماره موبایل در متن آگهی مجاز نیست .</span>
                                    <br/><br/>
                                    <textarea class="form-control font-iran p-4 font-size-14" style="min-height: 120px"
                                              name="details">{!! $response['advertisment']->details !!}</textarea>
                                </div>
                            </div>

                            <!-- AGENT INFO -->
                            <div id="agent_form"
                                 style="display: {{$response['advertisment']->owner_name=='' && $response['advertisment']->owner_mobile=='' ? 'none':'block' }}">
                                <h2 class="font-size-1rem text-danger bold py-3 text-right border-top line-35">این قسمت در
                                    آگهی نشان داده نمیشود و صرفا جهت ذخیره در پنل خود شما استفاده میگردد</h2>
                                <div class="form-row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <label for="owner_id" class="font-size-14">&nbsp; نام مالک </label>
                                        <input type="text" class="form-control font-iran font-size-14" name="owner_name"
                                               id="owner_id" value="{{$response['advertisment']->owner_name}}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <label for="owner_mobile_id" class="font-size-14">&nbsp; موبایل مالک </label>
                                        <input type="text" class="form-control font-iran font-size-14" name="owner_mobile"
                                               id="owner_mobile_id" value="{{$response['advertisment']->owner_mobile}}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <label for="owner_address_id" class="font-size-14">&nbsp; آدرس مالک </label>
                                        <input type="text" class="form-control font-iran font-size-14" name="owner_address"
                                               id="owner_address_id" value="{{$response['advertisment']->owner_address}}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <label for="owner_price_id" class="font-size-14">&nbsp; قیمت </label>
                                        <input type="text" class="form-control font-iran font-size-14" name="owner_price"
                                               id="owner_price_id" value="{{$response['advertisment']->owner_price}}">
                                    </div>
                                </div>


                                <div class="form-row mt-3">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                        <label for="owner_details_id" class="font-size-14">&nbsp; توضیحات اضافه</label>
                                        <textarea class="form-control font-iran p-2 font-size-14" name="owner_details"
                                                  id="owner_details_id">{{$response['advertisment']->owner_details}}</textarea>
                                    </div>
                                </div>


                            </div>

                            <div class="form-row my-4">
                                <input type="submit" class="btn btn-danger mx-auto fa-num" style="width: 200px!important;"
                                       value="ویرایش آگهی">
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </section>

        <!-- MODAL DELETE ADVERTISMENT -->
        <div class="modal fade mt-5" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true" style="direction:rtl!important;text-align:right;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header direction-ltr text-right">

                        <h5 class="modal-title" id="exampleModalLabel">آگهی شما حذف شود؟</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="float:right!important;">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        اگر مطمعن هستید که آگهی خود را حذف کنید، ادامه دهید
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('user.advertisment.destroy',$response['advertisment']->id)}}"
                           class="btn btn-danger font-iran bold font-size-14">
                            حذف آگهی
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>

        @if($response['advertisment']->latitude!='')
            edit_point_map('{{$response['advertisment']->latitude}}','{{$response['advertisment']->longitude}}','map');
        @else
             add_point_map('{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->latitude}}',
            '{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->longitude}}','map','14');
        @endif

    </script>
@endsection
