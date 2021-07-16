@extends('back.index')

@section('breadcrumb')
    <nav  class="col-12  my-4">
        <ol class="align-center breadcrumb">
            <li class="breadcrumb-item text-admin bold" aria-current="page">ثبت دسته جدید</li>
        </ol>
    </nav>
@endsection

@section('content')
    <!-- WELCOME -->
    <section class="direction-ltr bg-white pt-0" id="welcome">
        <div class="container-fluid my-5">
            @include('message.message')
            <h1 class="font-iran  font-size-17 text-dark bold text-right mt-3">جهت ثبت دسته جدید فرم زیر را تکمیل کنید</h1>
            <form  action="{{route('admin.category.store')}}" method="POST" class="form my-3 text-right direction-rtl border p-2 rounded">
                @csrf
                <input type="hidden" value="{{session()->get('adminid')}}" name="admin_id">
                <div class="form-row mt-3">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="name_id" class="font-size-15 bold"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام دسته جدید</label>
                        <input type="text" class="form-control fa-num  @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام دسته" value="{{old('name')}}">
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="slug_id" class="font-size-15 bold"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;آدرس دسته</label>
                        <input type="text" class="form-control  fa-num  @error('slug') is-invalid @enderror" id="slug_id" name="slug" placeholder="آدرس دسته" value="{{old('slug')}}">
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="parent_id" class="font-size-15 bold"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;دسته والد مورد نظر را انتخاب کنید</label>
                        <select id="parent_id" name="parent" class="form-control text-right font-iran"  data-placeholder="دسته والد مورد نظر را انتخاب کنید">
                            @foreach($categories as $category)
                                @if(isset($category->id))
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-row my-4">
                    <input type="submit" class="btn btn-success bg-admin mx-auto col-4 fa-num" value="اضافه کردن" >
                </div>
            </form>
        </div>
    </section>
    <!-- WELCOME -->


@endsection
