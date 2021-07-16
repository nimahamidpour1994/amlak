@extends('back.index')


@section('content')
    @include('message.message')
    @if(count($response['categories'])>0)
    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <td class="font-yekan">نام</td>
                <td class="font-yekan">مدیریت فیلدها</td>
                <td class="font-yekan">مشاهده زیردسته</td>
                <td class="font-yekan">ویرایش دسته</td>
                <td class="font-yekan">حذف دسته</td>
            </tr>
            <tbody>
                @foreach($response['categories'] as $category)
                    <tr class="text-center font-size-13">
                        <td class="font-yekan">{{$category->name}}</td>
                        <td><a href="{{route('admin.form.list',$category->id)}}" class="btn btn-outline-secondary btn-sm decoration-none font-yekan">مدیریت فیلد</a></td>
                        <td><a href="{{route('admin.category.show',$category->id)}}" class="btn btn-outline-success btn-sm decoration-none font-yekan">مشاهده زیر دسته</a></td>
                        <td><a href="{{route('admin.category.edit',$category->id)}}" class="btn btn-outline-primary btn-sm decoration-none font-yekan">ویرایش</a></td>
                        <td><a href="{{route('admin.category.destroy',$category->id)}}" class="btn btn-outline-danger btn-sm decoration-none font-yekan">حذف</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $response['categories']->links() }}
    </div>
    @else
    <div class="alert alert-warning text-right col-11 my-5 mx-auto font-yekan font-weight-bold text-center">زیر دسته ای برای این مورد یافت نشد</div>
    @endif

    <section class="direction-ltr bg-white pt-0">
        <div class="container-fluid my-5">
            <h1 class="font-iran  font-size-17 text-dark bold text-right mt-3">جهت ثبت دسته جدید فرم زیر را تکمیل کنید</h1>
            <form  action="{{route('admin.category.store')}}" method="POST" class="form admin-form">
                @csrf
                <input type="hidden" value="{{session()->get('adminid')}}" name="admin_id">
                <div class="form-row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام دسته جدید</label>
                        <input type="text" class="form-control admin-input  @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام دسته" value="{{old('name')}}">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="parent_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;دسته والد </label>
                        <select id="parent_id" name="parent" class="form-control text-right admin-input" readonly>
                           <option value="{{$response['parent']->id}}">{{$response['parent']->name}}</option>
                        </select>
                    </div>
                    <input type="hidden" value="advertisment" name="type">
                </div>

                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ثبت دسته جدید" >
                </div>
            </form>
        </div>
    </section>

@endsection
