@extends('back.index')


@section('content')
    @include('message.message')

    @if(count($response['states'])>0)
        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <td class="admin-table-hr">نام محل</td>
                    <td class="admin-table-hr">ویرایش</td>
                    <td class="admin-table-hr">حذف</td>
                </tr>
                <tbody>
                @foreach($response['states'] as $state)
                    <tr class="text-center">
                        <td class="admin-black">{{$state->name}}</td>
                        <td><a href="{{route('admin.city.state.edit',$state->id)}}" class="btn btn-outline-primary btn-sm font-yekan">ویرایش</a></td>
                        <td><a href="{{route('admin.city.state.destroy',$state->id)}}" class="btn btn-outline-danger btn-sm font-yekan">حذف</a></td>
                    </tr>
                @endforeach

                </tbody>

            </table>
            {{ $response['states']->links() }}
        </div>
    @else
        <div class="alert alert-warning text-right col-10 mx-auto">محلی ایجاد نشده است</div>
    @endif

    <div class="container-fluid mt-5">
        <h1 class="font-yekan font-size-15 text-dark bold text-right mt-3">جهت ثبت محل جدید فرم زیر را تکمیل کنید</h1>
        <form action="{{route('admin.city.state.store')}}" method="post" class="form admin-form">
            @csrf
            <div class="form-row mt-3">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                    <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام محل</label>
                    <input type="text" class="form-control  admin-input @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام محل" value="{{old('name')}}">
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
            <input type="hidden" id="lng" name="parent" value="{{ $response['city']->id}}">

            <div class="form-row my-4">
                <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ثبت محل جدید">
            </div>
        </form>
    </div>


@endsection

@section('script')

   <script> add_point_map('{{\App\Models\City::firstWhere('id', $response['city']->id)->latitude}}','{{\App\Models\City::firstWhere('id', $response['city']->id)->longitude}}','map','16')</script>
@endsection
