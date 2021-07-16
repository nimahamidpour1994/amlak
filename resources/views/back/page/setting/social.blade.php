@extends('back.index')


@section('content')
    @include('message.message')
        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <td class="admin-table-hr">شبکه اجتماعی</td>
                    <td class="admin-table-hr">لینک</td>
                    <td class="admin-table-hr">حذف</td>
                </tr>
                <tbody>
                @foreach($response['socials'] as $social)
                    <tr class="text-center font-size-14">
                        <td class="admin-danger">
                            @if($social->unique==='telegram')
                                تلگرام
                            @elseif($social->unique==='instagram')
                                اینستگرام
                            @elseif($social->unique==='whatsapp')
                                واتس آپ
                            @endif
                        </td>
                        <td class="admin-black">{{$social->value}}</td>
                        <td>
                            <a href="{{route('admin.social.destroy',$social->id)}}" class="btn btn-outline-danger btn-sm font-yekan">
                               حذف
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $response['socials']->links() }}
        </div>


    <section class="direction-ltr bg-white pt-0">
        <div class="container-fluid my-5">
            <h1 class="font-yekan font-size-15 text-dark bold text-right mt-3">جهت ثبت راه ارتباطی جدید فرم زیر را تکمیل کنید</h1>
            <form  action="{{route('admin.social.store')}}" method="POST" class="form admin-form">
                @csrf
                <div class="form-row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="type_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نوع راه ارتباطی</label>
                        <select class="form-control admin-input" id="type_id" name="type">
                            <option value="telegram">تلگرام</option>
                            <option value="instagram">اینستگرام</option>
                            <option value="whatsapp">واتس اپ</option>
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="link_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;لینک ارتباطی</label>
                        <input class="form-control admin-input" type="text" id="link_id" name="link" value="{{old('link')}}" placeholder="لینک راه ارتباطی">
                    </div>

                </div>


                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="افزودن">

                </div>
            </form>
        </div>
    </section>



@endsection
