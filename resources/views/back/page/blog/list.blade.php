@extends('back.index')

@section('content')

    @include('message.message')

    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <th class="admin-table-hr">ایکون</th>
                <th class="admin-table-hr">عنوان</th>
                <th class="admin-table-hr">دسته</th>
                <th class="admin-table-hr">ویرایش دسته</th>
                <th class="admin-table-hr">حذف دسته</th>
            </tr>
            <tbody>
                @foreach($response['blogs'] as $blog)
                    <tr class="text-center font-size-13">

                        <td>
                            <img class="admin-table-img" src="{{$blog->thumbnail!='' ? url($blog->thumbnail) : url('/front/img/structure/image-add-button.png')}}">
                        </td>
                        <td class="admin-info">{{$blog->title}}</td>
                        <td class="admin-success">{{$blog->Category->name}}</td>
                        <td>
                            <a href="{{route('admin.blog.edit',$blog->id)}}" class="btn btn-outline-primary btn-sm admin-a">
                                ویرایش
                            </a>
                        </td>
                        <td>
                            <a href="{{route('admin.blog.destroy',$blog->id)}}" class="btn btn-outline-danger btn-sm admin-a">
                                حذف
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$response['blogs']->links()}}
    </div>

@endsection
