@extends('back.index')


@section('content')

    @if(count($response['filters'])>0)
        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <th class="admin-table-hr">مقدار فیلتر</th>
                    <th class="admin-table-hr">حذف</th>
                </tr>
                <tbody>
                @foreach($response['filters'] as $filter)
                    <tr class="text-center font-size-14">
                        <td class="admin-black">{{$filter->unique . '  ' .$response['form']->unit }}</td>
                        <td ><a href="{{route('admin.filter.destroy',$filter->id)}}" class="btn btn-outline-danger btn-sm font-yekan">حذف</a></td>
                    </tr>
                @endforeach

                </tbody>

            </table>
        </div>
    @else
        <div class="alert alert-warning text-right col-10 mx-auto font-yekan">فیلتری برای این دسته ایجاد نشده</div>
    @endif

    <div class="container mt-5">
        @include('message.message')
        <h1 class="font-yekan font-size-15 text-dark font-weight-bold text-right mt-3">جهت ثبت مقدار جدید فرم زیر را تکمیل کنید</h1>
        <form action="{{route('admin.filter.add',$response['form']->id)}}" method="post" class="form admin-form">
            @csrf
            <div class="form-row mt-3">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                    <label for="value_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i> مقدار فیلتر </label>
                    <input type="text" class="form-control admin-input  @error('value_id') is-invalid @enderror"
                           id="value_id" name="value" placeholder="مقدار فیلتر" value="{{old('value')}}" onkeyup="digitGroup(this,'filtervalue','{{$response['form']->unit}}')">
                    <div class="font-size-14 text-dark text-right fa-num p-1" id="filtervalue">

                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                    <label for="name_id" class="admin-input-label">
                        <i class="fas fa-pencil-alt prefix text-right"></i>
                        نام فیلتر
                        <span class="admin-danger font-size-12">(اختیاری)</span>
                    </label>
                    <input type="text" class="form-control admin-input  @error('value_id') is-invalid @enderror"
                           id="name_id" name="name" placeholder="نام فیلتر" value="{{old('name')}}">
                    <div class="font-size-14 text-dark text-right fa-num p-1" id="filtervalue">

                    </div>
                </div>
            </div>


            <div class="form-row my-4">
                <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ثبت مقدار جدید">

            </div>
        </form>
    </div>


@endsection
