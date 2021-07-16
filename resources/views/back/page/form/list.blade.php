@extends('back.index')


@section('content')
    @include('message.message')

    @if(count($response['forms'])>0)
        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <td class="font-yekan">نام فیلد</td>
                    <td class="font-yekan">نوع</td>
                    <td class="font-yekan">نمایش در بند انگشتی</td>
                    <td class="font-yekan">الزامی بودن</td>
                    <td class="font-yekan">واحد</td>
                    <td class="font-yekan">مدیریت فیلتر</td>
                    <td class="font-yekan">ویرایش</td>
                    <td class="font-yekan">حذف</td>
                </tr>
                <tbody>
                @foreach($response['forms'] as $form)
                    <tr class="text-center font-size-13">
                        <td class="admin-black">{{$form->name}}</td>
                        <td class="admin-danger">{{$form->FormatField->unique}}</td>
                        <td class="admin-info"> {{$form->show_thumbnail==1 ? 'بله' : 'خیر'}} </td>
                        <td class="admin-danger"> {{$form->force==1 ? 'بله' : 'خیر'}} </td>
                        <td class="admin-success"> {{$form->unit}} </td>
                        <td><a href="{{route('admin.filter.list',$form->id)}}" class="btn btn-outline-secondary btn-sm font-yekan">مدیریت فیلتر</a></td>
                        <td><a href="{{route('admin.form.edit',$form->id)}}" class="btn btn-outline-primary btn-sm  font-yekan">ویرایش</a></td>
                        <td><a href="{{route('admin.form.delete',$form->id)}}" class="btn btn-outline-danger btn-sm font-yekan">حذف</a></td>
                    </tr>
                @endforeach

                </tbody>

            </table>
            {{ $response['forms']->links() }}
        </div>
    @else
        <div class="alert alert-warning text-right col-10 mx-auto">فیلدی برای این دسته ایجاد نشده</div>
    @endif

    <div class="container-fluid mt-5">
        <h1 class="font-yekan font-size-15 text-dark bold text-right mt-3">جهت ثبت فیلد جدید فرم زیر را تکمیل کنید</h1>
        <form action="{{route('admin.form.store')}}" method="post" class="form admin-form">
            @csrf
                <input type="hidden" name="parent" value="{{$response['category']->id}}">
            <div class="form-row mt-3">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام فیلد</label>
                    <input type="text" class="form-control admin-input  @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام فیلد" value="{{old('name')}}">
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="field_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نوع فیلد</label>
                    <select id="field_id" name="field" class="form-control text-right admin-input"  data-placeholder="نوع فیلد را انتخاب کنید">
                        @foreach($response['fields'] as $field)
                            @if(isset($field->id))
                                <option value="{{$field->value}}">{{$field->unique}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="unit_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;واحد<span class="admin-danger font-size-12">(اختیاری)</span></label>
                    <input type="text" class="form-control admin-input @error('unit') is-invalid @enderror" id="unit_id" name="unit" placeholder="تومان ، متر ..." value="{{old('unit')}}">
                </div>

                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="show_thumbnail_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نمایش در بند انگشتی</label>
                    <select id="show_thumbnail_id" name="show_thumbnail" class="form-control text-right admin-input"  data-placeholder="نمایش در بند انگشتی">
                        <option value="0">خیر</option>
                        <option value="1">بله</option>
                    </select>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="force_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;اجباری بودن</label>
                    <select id="force_id" name="force" class="form-control text-right admin-input"  data-placeholder="اجباری بودن">
                        <option value="0">خیر</option>
                        <option value="1">بله</option>
                    </select>
                </div>
            </div>

            <div class="form-row mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="value_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;مقادیر مورد نظر<span class="admin-danger font-size-12"> (با - جدا کنید) </span></label>
                    <textarea  class="form-control direction-rtl font-iran p-2 @error('value') is-invalid @enderror" id="value_id" name="value" placeholder="مقادیر فیلد"></textarea>
                </div>
            </div>


            <div class="form-row my-4">
                <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="افزودن" >

            </div>
        </form>
    </div>


@endsection
