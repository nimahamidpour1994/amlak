@extends('back.index')

@section('content')

    @include('message.message')

    @if(count($response['cities'])>0)
        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <th class="admin-table-hr">نام شهر</th>
                    <th class="admin-table-hr">محله ها</th>
                    <th class="admin-table-hr">ویرایش</th>
                    <th class="admin-table-hr">حذف</th>
                </tr>
                <tbody>
                @foreach($response['cities'] as $city)
                    <tr class="text-center">
                        <td class="admin-black">{{$city->name}}</td>
                        <td><a href="{{route('admin.city.state.list',$city->id)}}" class="btn btn-outline-success btn-sm font-yekan">لیست محله ها</a></td>
                        <td><a href="{{route('admin.city.edit',$city->id)}}" class="btn btn-outline-primary btn-sm font-yekan">ویرایش</a></td>
                        <td><a href="{{route('admin.city.destroy',$city->id)}}" class="btn btn-outline-danger btn-sm font-yekan">حذف</a></td>
                    </tr>
                @endforeach

                </tbody>

            </table>
            {{ $response['cities']->links() }}
        </div>
    @else
        <div class="alert alert-warning text-right col-10 font-yekan mx-auto">شهری ایجاد نشده است</div>
    @endif

    <div class="container-fluid mt-5">
        <h1 class="font-yekan font-size-15 text-dark bold text-right mt-3">جهت ثبت  شهر جدید فرم زیر را تکمیل کنید</h1>
        <form action="{{route('admin.city.store')}}" method="post" class="form admin-form">
            @csrf
            <div class="form-row mt-3">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                    <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام شهر</label>
                    <input type="text" class="form-control admin-input  @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام شهر" value="{{old('name')}}">
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <div id="map" class="col-12" style="height: 300px">

                    </div>
                    <div class="col-12 text-left direction-ltr">
                        <input type="button" class="btn btn-danger btn-sm font-size-14 font-iran mt-3 d-none"
                               id="deleteposition"  value="حذف موقعیت"/>
                    </div>
                </div>
            </div>
        <input type="hidden" id="lat" name="lat">
        <input type="hidden" id="lng" name="lng">

            <div class="form-row my-4">
                <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ثبت شهر جدید">
            </div>
        </form>
    </div>


@endsection


@section('script')

    <script>
        add_point_map('{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->latitude}}',
            '{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->longitude}}','map','14');
    </script>
@endsection
