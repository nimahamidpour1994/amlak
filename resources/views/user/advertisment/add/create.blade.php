@extends('user.index')

@section('title','ثبت رایگان آگهی')

@section('keywords','ثبت اگهی فروش خانه در اصفهان - ثبت اگهی اجاره خانه در اصفهان - ثبت اگهی فروش باغ در اصفهان - ثبت اگهی فروش دفتر کار در اصفهان')

@section('description',$response['app_description'])


@section('content')

    <section>
        <div class="container-fluid my-5 col-12">
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12 mx-auto">

                <!-- TITLE AND CHANGE CATEGORY -->
                <div class="row border rounded py-4 px-1 text-right mx-auto">
                    <div class="col-7 text-right">
                        <span class="font-size-12 text-right">{{$response['title']}}</span>
                    </div>
                    <div class="col-5 text-right text-xl-left text-lg-left">
                        <a class="text-decoration-none text-divar font-size-12" href="{{route('user.advertisment.add','choose-category')}}">تغییر دسته بندی</a>
                    </div>
                </div>

                <section class="bg-white pt-0 ">
                    <form action="{{route('user.advertisment.store')}}" method="POST"  id="testform" class="form text-right border rounded p-3 my-3 " enctype="multipart/form-data">
                    @csrf

                    <!-- SELECT STATE -->
                        <div class="form-row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="city" class="font-size-15">&nbsp; شهر</label>
                                <select id="city" name="city" class="form-control text-right font-iran font-size-14 shadow-none"
                                        data-placeholder="انتخاب شهر" onclick="changeState()" onchange="set_view(this,'1',14,'map_parent')">
                                    @foreach($response['cities'] as $city)
                                        @if(isset($city->id))
                                            <option value="{{$city->id}}" {{$city->id==\Illuminate\Support\Facades\Cookie::get('city') ? 'selected' : ''}}>{{$city->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="state" class="font-size-14">&nbsp;  محدودهٔ آگهی</label>
                                <select id="state" name="state" class="form-control text-right font-iran font-size-14 shadow-none @error('state') is-invalid @enderror" onchange="set_view(this,'2',14,'map_parent')">
                                    <option value="" hidden >انتخاب محله</option>
                                    @foreach($response['states'] as $state)
                                        @if(isset($state->id))
                                            <option value="{{$state->id}}" {{old('state') === $state->id ? 'selected' : ''}}>{{$state->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- SELECT MAP -->
                        <div class="form-row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4" id="map_parent">
                                @error("lat")
                                <div class="col-12 p-1 text-divar font-iran font-size-14  bold border border-danger rounded">
                                    نقشه الزامی می باشد
                                </div>
                                @enderror
                                <div id="map" class="col-12" style="height: 300px">

                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 text-left direction-ltr">
                                <input type="button" class="btn btn-danger btn-sm font-size-14 font-iran mt-3 d-none"
                                       id="deleteposition"  value="حذف موقعیت"/>
                            </div>
                        </div>

                        <!-- SELECT IMG -->
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
                                        <div class="image-uploader__dropzone" aria-disabled="false" style="position: relative">
                                            <i class="fas fa-camera"></i>
                                            <input type="file" name="photo[]" id="photo" accept="image/x-png,image/gif,image/jpeg" multiple
                                                   class="d-none" onchange="setimage(this)">
                                        </div>
                                    </label>
                                </div>

                                <!-- ERROR IMG -->
                                <div class="ui message messages messages--error d-none" id="errormain">
                                    <div class="content">
                                        <ul class="list" id="errorul">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CUSTOM FIELD -->
                        <div class="form-row">

                            @foreach($response['fields'] as $field)

                                @if($field->field === 'text')
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                                        <label for="parent_id" class="font-size-14 text-dark">
                                            {{$field->name}}&nbsp;
                                            <span class="text-danger bold font-size-12">({{$field->unit}})</span>
                                        </label>
                                        <input type="text" class="form-control fa-num font-size-14 @error("field".$field->id) is-invalid @enderror"
                                               name="field{{$field->id}}" @error("field".$field->id) placeholder="این فیلد الزامی می باشد" @enderror value="{{old('field'.$field->id)}}">
                                    </div>

                                @elseif($field->field === 'number')
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                                        <label for="parent_id" class="font-size-14 text-dark">
                                            {{$field->name}}&nbsp;
                                            <span class="text-danger bold font-size-12">({{$field->unit}})</span>
                                        </label>
                                        <input type="number" class="form-control fa-num font-size-14 @error("field".$field->id) is-invalid @enderror"
                                               name="field{{$field->id}}"  @error("field".$field->id) placeholder="این فیلد الزامی می باشد" @enderror
                                               onkeyup="digitGroup(this,'convert_value{{$field->id}}','{{$field->unit}}')" value="{{old('field'.$field->id)}}">
                                        <div class="font-size-14 text-dark text-right fa-num p-1" id="convert_value{{$field->id}}">

                                        </div>
                                    </div>

                                @elseif($field->field === 'list')
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                                        <label for="parent_id" class="font-size-14 text-dark">
                                            {{$field->name}}
                                        </label>
                                        <select name="field{{$field->id}}" id="" class="form-control fa-num @error("field".$field->id) is-invalid @enderror">
                                            <option value="" hidden></option>
                                            @foreach($options=explode('-',$field->value) as $option)
                                                <option value="{{$option}}" class="fa-num font-size-14" {{old('field'.$field->id)==$option ? 'selected' : ''}}>{{$option}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                @elseif($field->field === 'radio')
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3 d-inline-block">
                                        <label for="parent_id" class="font-size-14 text-dark">
                                            {{$field->name}}
                                        </label>
                                        <div class="row">
                                            <div class="col-12 direction-rtl p-2">
                                                <table class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                                    <tr class="border-none">
                                                        @foreach($options=explode('-',$field->value) as $option)
                                                            <td class="border-none direction-ltr text-right">
                                                                @if(count($options)>1)
                                                                    <label for="radio{{$field->id}}{{$option}}" class="font-size-14">{{$option}}</label>

                                                                    <input type="radio" value="{{$option}}" name="field{{$field->id}}"
                                                                           id="radio{{$field->id}}{{$option}}"
                                                                           class="mx-1 fa-num font-size-15" checked>
                                                                @else
                                                                    <input type="checkbox" name="camera_video[]" value="{{$option}}"> <label>{{$option}}</label>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                @elseif($field->field === 'checkbox')
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3 d-inline-block">

                                        @if(count(explode('-',$field->value))==1)
                                            <input type="checkbox" name="field{{$field->id}}" class="mx-2" id="checkbox{{$field->id}}{{$field->value}}" value="{{$field->value}}" style="transform: scale(1.0);float: right!important;">

                                            <label for="checkbox{{$field->id}}{{$field->value}}" class="font-size-14 text-dark">
                                                {{$field->name}}
                                            </label>

                                        @else
                                            <label for="parent_id" class="font-size-14 text-dark">
                                                {{$field->name}}
                                            </label>
                                            <div class="row">
                                                <div class="col-12 direction-rtl p-2">
                                                    <table class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                                        <tr class="border-none">
                                                            @foreach($options=explode('-',$field->value) as $option)
                                                                <td class="border-none direction-ltr text-right">
                                                                    <label for="checkbox{{$field->id}}{{$option}}" class="font-size-14">{{$option}}</label>

                                                                    <input type="checkbox" value="{{$option}}" name="field{{$field->id}}[]"
                                                                           id="checkbox{{$field->id}}{{$option}}"
                                                                           style="transform: scale(1.0);">

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

                        <!-- SELECT URGENT PERSON -->
                        <div class="form-row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                                <label for="parent_id" class="font-size-14 text-dark">
                                    آگهی‌دهنده
                                </label>
                                <table class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                    <tbody><tr class="border-none">
                                        <td class="border-none direction-ltr text-right">
                                            <label for="person_id" class="font-size-14">شخصی</label>
                                            <input type="radio" value="person" name="who" id="person_id" class="mx-1 fa-num font-size-15" onclick="show_more_field('person')" checked >
                                        </td>
                                        <td class="border-none direction-ltr text-right">
                                            <label for="agent_id" class="font-size-14">مشاور املاک</label>
                                            <input type="radio" value="agent" name="who" id="agent_id" class="mx-1 fa-num font-size-15" onclick="show_more_field('agent')">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- SELECT MOBILE -->
                        <div class="form-row d-none">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="parent_id" class="font-size-15">&nbsp; شماره موبایل</label>
                                <input class="form-control fa-num direction-ltr" type="number" placeholder="09**" name="mobile" value="{{Auth()->user()->mobile}}" readonly>
                            </div>
                        </div>

                        <!-- MAP HIDDEN VALUE -->
                        <input type="text" hidden readonly name="lat" id="lat">
                        <input type="text" hidden readonly name="lng" id="lng">

                        <!-- ADVERTISMENT TITLE -->
                        <div class="form-row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="name" class="font-size-15">&nbsp; عنوان آگهی</label>
                                <br/>
                                <span class="font-size-12 text-secondary"> در عنوان آگهی به موارد مهم و چشمگیر اشاره کنید.</span>
                                <br/>
                                <input type="text" class="form-control font-iran font-size-14 @error('name') is-invalid @enderror" @error('name') placeholder="این فیلد الزامی می باشد" @enderror name="name" id="name" value="{{old('name')}}">
                            </div>
                        </div>

                        <!-- ADVERTISMENT DESCRIPTION -->
                        <div class="form-row mt-3">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="details" class="font-size-15">&nbsp; توضیحات آگهی</label>
                                <br/>
                                <span class="font-size-12 text-secondary">جزئیات و نکات قابل توجه آگهی خود را کامل و دقیق بنویسید. درج شماره موبایل در متن آگهی مجاز نیست .</span>
                                <br/>
                                <textarea class="form-control font-iran p-2 font-size-14 @error('details') is-invalid @enderror" style="min-height: 120px" name="details" id="details" @error('details') placeholder="این فیلد الزامی می باشد" @enderror>{{old('details')}}</textarea>
                            </div>
                        </div>

                        <!-- OWNER DETAILS  -->
                        <div id="agent_form" style="display:none">
                            <h2 class="font-size-1rem text-danger bold py-3 text-right border-top line-35">این قسمت در آگهی نشان داده نمیشود و صرفا جهت ذخیره در پنل خود شما استفاده میگردد</h2>
                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="owner_id" class="font-size-15">&nbsp;  نام مالک </label>
                                    <input type="text" class="form-control font-iran font-size-14" name="owner_name" id="owner_id" value="{{old('owner_name')}}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="owner_mobile_id" class="font-size-15">&nbsp;  موبایل مالک </label>
                                    <input type="text" class="form-control font-iran font-size-14" name="owner_mobile" id="owner_mobile_id" value="{{old('owner_mobile')}}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="owner_address_id" class="font-size-15">&nbsp;  آدرس مالک </label>
                                    <input type="text" class="form-control font-iran font-size-14" name="owner_address" id="owner_address_id" value="{{old('owner_address')}}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="owner_price_id" class="font-size-15">&nbsp;  قیمت </label>
                                    <input type="text" class="form-control font-iran font-size-14" name="owner_price" id="owner_price_id" value="{{old('owner_price')}}">
                                </div>
                            </div>


                            <div class="form-row mt-3">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                                    <label for="owner_details_id" class="font-size-15">&nbsp; توضیحات اضافه</label>
                                    <textarea class="form-control font-iran p-2 font-size-14"  name="owner_details" id="owner_details_id">{{old('owner_details')}}</textarea>
                                </div>
                            </div>


                        </div>

                        <!-- SELECT LISTEN  BELL -->
                        <div class="form-row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 my-2">
                                <label for="parent_id" class="font-size-14 text-dark mr-2">
                                    ارسال گوش به زنگ
                                    <span class="font-size-12 text-divar font-weight-bold">(در صورتی که افرادی منتظر آگهی با این مشخصات هستند اطلاع بده.هزینه بر اساس تعداد افراد منتظر این آگهی محاسبه میگردد.)</span>
                                </label>
                                <table class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                    <tbody><tr class="border-none">
                                        <td class="border-none direction-ltr text-right">
                                            <label for="listenbell_yes_id" class="font-size-14">بله</label>
                                            <input type="radio" value="yes" name="listenbell" id="listenbell_yes_id" class="mx-1 fa-num font-size-15" checked>
                                        </td>
                                        <td class="border-none direction-ltr text-right">
                                            <label for="listenbell_no_id" class="font-size-14">خیر</label>
                                            <input type="radio" value="no" name="listenbell" id="listenbell_no_id" class="mx-1 fa-num font-size-15">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ADVERTISMENT SUBMIT -->
                        <div class="form-row my-4">
                            <input type="submit" class="btn btn-danger mx-auto fa-num" style="width: 200px!important;" value="ارسال آگهی">
                        </div>


                    </form>
                </section>

            </div>
        </div>
    </section>

@endsection

@section('script')

    <script>
        @if(\Illuminate\Support\Facades\Cookie::get('city')!='')
        add_point_map('{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->latitude}}',
            '{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->longitude}}','map','14');
        @else
        add_point_map('{{\App\Models\City::orderBy('id','ASC')->first()->latitude}}',
            '{{\App\Models\City::orderBy('id','ASC')->first()->longitude}}','map','14');
        @endif

    </script>

@endsection
