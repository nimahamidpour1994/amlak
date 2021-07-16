@extends('back.index')

@section('content')
    @include('message.message')

    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <th class="admin-table-hr">ایکون</th>
                <th class="admin-table-hr">نوع</th>
                <th class="admin-table-hr">عنوان</th>
                <th class="admin-table-hr">موارد تعریف شده</th>
                <th class="admin-table-hr">ویرایش</th>
            </tr>
            <tbody>
                @foreach($response['pages'] as $page)
                    <tr class="text-center">
                        <td>
                            @if($page->unique==='service')
                                <img src="{{optional($page->Category)->icon !='' ? url(optional($page->Category)->icon) : url('/front/img/structure/image-add-button.png')}}" class="admin-table-img">
                            @elseif($page->unique === 'blog')
                                <img src="{{optional($page->Page)->thumbnail!='' ? url(optional($page->Page)->thumbnail) : url('/front/img/structure/image-add-button.png')}}" class="admin-table-img">
                           @else
                                <img src="{{$response['app_logo']!='' ? url($response['app_logo']) : url('/front/img/structure/image-add-button.png')}}" class="admin-table-img">

                            @endif
                        </td>
                        <td>
                            @if($page->unique === 'blog')
                                <span class="admin-danger">بلاگ</span>
                            @elseif($page->unique === 'service')
                                <span class="admin-info">خدمات</span>
                            @else
                                <span class="admin-success">صفحه اصلی</span>
                            @endif
                        </td>
                        <td class="admin-black">
                            @if($page->unique==='service')
                               {{optional( $page->Category)->title }}
                            @elseif($page->unique === 'blog')
                                {{ optional($page->Page)->title }}
                            @else
                                صفحه اصلی
                            @endif
                        </td>
                        <td class="admin-black">
                            @if(\App\Models\Meta::firstWhere([['model_id',$page->model_id],['model',$page->model],['unique','title']])!='')
                                <span class="admin-danger">عنوان صفحه،</span>
                            @endif
                            @if(\App\Models\Meta::firstWhere([['model_id',$page->model_id],['model',$page->model],['unique','keyword']])!='')
                                <span class="admin-info">کلمات کلیدی،</span>
                            @endif
                            @if(\App\Models\Meta::firstWhere([['model_id',$page->model_id],['model',$page->model],['unique','description']])!='')
                                <span class="admin-success">توضیحات</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.seo.show',$page->id)}}" class="btn btn-outline-primary btn-sm admin-a">
                               ویرایش
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $response['pages']->links() }}
    </div>



@endsection
