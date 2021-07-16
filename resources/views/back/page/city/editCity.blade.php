@extends('back.index')


@section('content')


    <div class="container-fluid mt-5">

        @include('message.message')

        <form action="{{route('admin.city.update',$response['city']->id)}}" method="post" class="form admin-form">
            @csrf
            <div class="form-row mt-3">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                    <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام شهر</label>
                    <input type="text" class="form-control admin-input  @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام شهر" value="{{$response['city']->name}}">
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
            <input type="text" hidden readonly name="lat" id="lat" value="{{$response['city']->latitude}}">
            <input type="text" hidden readonly name="lng" id="lng" value="{{$response['city']->longitude}}">

            <div class="form-row my-4">
                <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit"  value="ثبت تغییرات">

            </div>
        </form>
    </div>


@endsection


@section('script')
    <script>
          @if($response['city']->latitude!='')
            edit_point_map('{{$response['city']->latitude}}','{{$response['city']->longitude}}','map');
        @else
        add_point_map('{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->latitude}}',
            '{{\App\Models\City::firstWhere('id',\Illuminate\Support\Facades\Cookie::get('city'))->longitude}}','map','14');
        @endif
    </script>
@endsection
