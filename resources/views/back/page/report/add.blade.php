@extends('back.index')


@section('content')
    @include('message.message')

    @if(count($response['reports'])>0)
    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <th class="admin-table-hr">عنوان</th>
                <th class="admin-table-hr">حذف دسته</th>
            </tr>
            <tbody>
                @foreach($response['reports'] as $report)
                    <tr class="text-center font-size-13">
                        <td class="admin-black">{{$report->unique}}</td>
                        <td><a href="{{route('admin.report.destroy',$report->id)}}" class="btn btn-outline-danger btn-sm font-yekan">حذف</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-warning text-right col-10 mx-auto font-yekan">موردی یافت نشد</div>
    @endif

    <section class="direction-ltr bg-white pt-0">
        <div class="container-fluid my-5">
            <h1 class="font-yekan font-size-15 text-dark bold text-right mt-3">جهت ثبت دسته جدید فرم زیر را تکمیل کنید</h1>
            <form  action="{{route('admin.report.store')}}" method="POST" class="form admin-form">
                @csrf
                <input type="hidden" value="{{session()->get('adminid')}}" name="admin_id">
                <div class="form-row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;عنوان دسته جدید</label>
                        <input type="text" class="form-control admin-input  @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام دسته" value="{{old('name')}}">
                    </div>
                </div>

                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ثبت دسته جدید">
                </div>
            </form>
        </div>
    </section>

@endsection
