@extends('back.index')

@section('content')

    <div class="container-fluid mt-5">
        @include('message.message')
        <form action="{{route('admin.form.update', $response['form']->id)}}" method="post" class="form admin-form">
            @csrf
            <div class="form-row mt-3">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام فیلد</label>
                    <input type="text" class="form-control admin-input  @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام فیلد" value="{{$response['form']->name}}">
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="field_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نوع فیلد</label>
                    <select id="field_id" name="field" class="form-control text-right admin-input">
                        @foreach($response['fields'] as $field)
                            @if(isset($field->value))
                                    <option value="{{$field->value}}" {{$field->value === $response['form']->field ? 'selected' : ''}}>{{$field->unique}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="unit_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;واحد<span class="text-danger">(اختیاری)</span></label>
                    <input type="text" class="form-control admin-input  @error('unit') is-invalid @enderror" id="unit_id" name="unit" placeholder="تومان ، متر ..." value="{{$response['form']->unit}}">
                </div>
                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="show_thumbnail_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نمایش در بند انگشتی</label>
                    <select id="show_thumbnail_id" name="show_thumbnail" class="form-control text-right admin-input">
                        <option value="0" {{$response['form']->show_thumbnail === 0 ? 'selected' : ''}}>خیر</option>
                        <option value="1" {{$response['form']->show_thumbnail === 1 ? 'selected' : ''}}>بله</option>
                    </select>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="force_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;اجباری بودن</label>
                    <select id="force_id" name="force" class="form-control text-right admin-input">
                        <option value="0" {{$response['form']->force === 0 ? 'selected' : ''}}>خیر</option>
                        <option value="1" {{$response['form']->force === 1 ? 'selected' : ''}}>بله</option>
                    </select>
                </div>

            </div>

            <div class="form-row mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                    <label for="value_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;مقادیر مورد نظر<span class="text-danger"> (با - جدا کنید) </span></label>
                    <textarea  class="form-control direction-rtl admin-input p-2  @error('value') is-invalid @enderror" id="value_id" name="value" placeholder="مقادیر فیلد">{{$response['form']->value}}</textarea>
                </div>
            </div>

            <div class="form-row my-4">
                <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ثبت تغییرات">

            </div>
        </form>
    </div>


@endsection
