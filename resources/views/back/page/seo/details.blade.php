@extends('back.index')

@section('content')
    @include('message.message')

    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <th class="admin-table-hr">نوع</th>
                <th class="admin-table-hr">محتوا</th>
                <th class="admin-table-hr">حذف</th>
            </tr>
            <tbody>
                @foreach($response['metas'] as $meta)
                    <tr class="text-center">

                        <td>
                            @if($meta->unique === 'keyword')
                                <span class="admin-danger">keyword</span>
                            @elseif($meta->unique === 'description')
                                <span class="admin-info">description</span>
                            @else
                                <span class="admin-info">title</span>
                            @endif
                        </td>
                        <td class="admin-black">{{$meta->value}}</td>
                        <td>
                            <a href="{{route('admin.seo.destroy',$meta->id)}}" class="btn btn-outline-primary btn-sm admin-a">
                               حذف
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <section class="direction-ltr bg-white pt-0">
        <div class="container-fluid my-5">
            <h1 class="admin-h1">ثبت دسته جدید</h1>
            <form  action="{{route('admin.seo.store',$response['parent'])}}" method="POST"  class="form admin-form">
                @csrf

                <div class="form-row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="type_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;نوع</label>
                        <select class="form-control admin-input" id="type" name="type">
                            @foreach($response['meta_key'] as $key)
                                <option class="admin-input" value="{{$key->unique}}">{{$key->value}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="value_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp;محتوا</label>
                        <textarea class="form-control admin-input p-3 @error('value') is-invalid @enderror" style="height: 100px" id="value_id" name="value" placeholder="عنوان صفحه، کلمه کلیدی، توضیحات" ></textarea>
                    </div>

                </div>

                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-8 col-sm-10 col-xs-10 btn admin-submit" value="ثبت" >
                </div>
            </form>
        </div>
    </section>


@endsection
