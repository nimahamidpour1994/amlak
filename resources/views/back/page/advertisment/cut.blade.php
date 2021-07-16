@extends('back.index')

@section('title','هرس آگهی')
@section('description','')


@section('content')

    <div class="container my-5">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                <h2 class="text-right font-iran bold font-size-20">هرس آگهی </h2>
            </div>
        </div>
    </div>

        <div class="container">
            <div class="row mx-auto">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-sm-12 mx-auto">

                    @include('message.message')
                    <form action="{{route('admin.advertisment.delete.old')}}" method="POST"
                          class="form text-right border p-3 rounded">
                        @csrf
                        <div class="form-row">

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                                <label for="parent_id" class="font-size-15 bold"><i
                                        class="fas fa-pencil-alt prefix text-right"></i>&nbsp;تعداد روز گذشته</label>
                                <input type="number" class="form-control font-iran" name="day" placeholder="تعداد روز گذشته">
                            </div>

                        </div>



                        <div class="form-row my-4">
                            <input type="submit" class="btn btn-success bg-admin mx-auto fa-num" style="width: 250px!important;"
                                   value="حذف آگهی های منقضی شده">
                        </div>

                    </form>

                </div>
            </div>
        </div>

@endsection
