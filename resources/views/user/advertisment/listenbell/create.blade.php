@extends('user.index')

@section('title','ثبت رایگان آگهی')

@section('keywords','ثبت اگهی فروش خانه در اصفهان - ثبت اگهی اجاره خانه در اصفهان - ثبت اگهی فروش باغ در اصفهان - ثبت اگهی فروش دفتر کار در اصفهان')

@section('description',$response['app_description'])


@section('content')

    <section>
         <div class="container-fluid my-5 col-12">
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12 mx-auto">

            <!--  SHOW MESSAGE ==> SUCCESS OR FAILD -->
            @if(session('success'))
                <div class="alert alert-success direction-rtl font-size-14 font-yekan text-right bold"> {{session('success')}}</div>
            @endif

            @if(session('warning'))
                <div class="alert alert-danger direction-rtl font-size-14 font-yekan text-right bold"> {{session('warning')}}</div>
            @endif
            <!--  SHOW MESSAGE -->

            <!-- TITLE AND CHANGE CATEGORY -->
            <div class="row border rounded py-4 px-1 text-right mx-auto">
                <div class="col-7 text-right">
                    <span class="font-size-12 text-right">{{$response['title']}}</span>
                </div>
                <div class="col-5 text-right text-xl-left text-lg-left">
                    <a class="text-decoration-none text-divar font-size-12" href="{{route('user.listenbell.add','choose-category')}}">تغییر دسته بندی</a>
                </div>
            </div>

            <section class="bg-white pt-0 ">
                <form action="{{route('user.listenbell.store')}}" method="POST"  id="testform" class="form text-right border rounded p-3 my-3 " enctype="multipart/form-data">
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

                    <!-- SELECT URGENT PERSON -->
                    <div class="form-row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                            <label for="parent_id" class="font-size-14 text-dark">
                                آگهی‌دهنده
                            </label>
                            <table class="table border-none col-xl-6 col-lg-6 col-md-10 col-sm-12 col-xs-12 text-right">
                                <tbody><tr class="border-none">
                                    <td class="border-none direction-ltr text-right">
                                        <label for="person_id" class="font-size-14">هر دو </label>
                                        <input type="radio" value="both" name="who" id="person_id" class="mx-1 fa-num font-size-15" onclick="show_more_field('person')" checked >
                                    </td>

                                    <td class="border-none direction-ltr text-right">
                                        <label for="person_id" class="font-size-14">شخصی</label>
                                        <input type="radio" value="person" name="who" id="person_id" class="mx-1 fa-num font-size-15" onclick="show_more_field('person')">
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

                   <!-- CUSTOM FIELD -->
                   <div class="form-row">


                       @foreach($response['fields'] as $field)

                           <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                               <label for="minfield{{$field->id}}" class="font-size-14 text-dark">
                                   حداقل
                                     {{$field->name}}
                                   <span class="text-danger bold font-size-12">({{$field->unit}})</span>
                               </label>
                               <input type="number"
                                      class="form-control fa-num font-size-14 @error("minfield".$field->id) is-invalid @enderror"
                                      name="minfield{{$field->id}}" id="minfield{{$field->id}}"
                                      @error("minfield".$field->id) placeholder="این فیلد الزامی می باشد" @enderror
                                      onkeyup="digitGroup(this,'convert_value_min{{$field->id}}','{{$field->unit}}')"
                                      value="{{old('minfield'.$field->id) != null ? old('minfield'.$field->id) : 0}}">
                               <div class="font-size-14 text-dark text-right fa-num p-1"
                                    id="convert_value_min{{$field->id}}">

                               </div>
                           </div>

                           <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4 d-inline-block">
                               <label for="maxfield{{$field->id}}" class="font-size-14 text-dark">
                                   حداکثر
                                     {{$field->name}}
                                   <span class="text-danger bold font-size-12">({{$field->unit}})</span>
                               </label>
                               <input type="number"
                                      class="form-control fa-num font-size-14 @error("maxfield".$field->id) is-invalid @enderror"
                                      name="maxfield{{$field->id}}" id="maxfield{{$field->id}}"
                                      @error("maxfield".$field->id) placeholder="این فیلد الزامی می باشد" @enderror
                                      onkeyup="digitGroup(this,'convert_value_max{{$field->id}}','{{$field->unit}}')"
                                      value="{{old('maxfield'.$field->id)}}">
                               <div class="font-size-14 text-dark text-right fa-num p-1"
                                    id="convert_value_max{{$field->id}}">

                               </div>
                           </div>
                       @endforeach
                   </div>

                   <!-- ADVERTISMENT SUBMIT -->
                   <div class="form-row my-4">
                        <input type="submit" class="btn btn-danger mx-auto fa-num" style="width: 200px!important;" value="ثبت گوش به زنگ">
                    </div>

                </form>
            </section>

        </div>
    </div>
    </section>
@endsection

