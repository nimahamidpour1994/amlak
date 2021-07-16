@extends('back.index')

@section('content')

    <section class="direction-ltr bg-white pt-0">
        <div class="container-fluid my-5">
            @include('message.message')
            <form  action="{{route('admin.category.update',$response['category']->id)}}" method="POST" class="form admin-form">
                @csrf
                <div class="form-row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="name_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نام دسته</label>
                        <input type="text" class="form-control admin-input @error('name') is-invalid @enderror" id="name_id" name="name" placeholder="نام دسته" value="{{$response['category']->name}}">
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="parent_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;دسته والد مورد نظر را انتخاب کنید</label>
                        <select id="parent_id" name="parent" class="form-control text-right admin-input">
                            @foreach($response['categories'] as $category)
                                <option value="{{$category->id}}" {{$response['category']->parent === $category->id ? 'selected' :''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" value="advertisment" name="type">
                </div>


                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ثبت تغییرات" >
                </div>
            </form>
        </div>
    </section>
    <!-- WELCOME -->


@endsection
