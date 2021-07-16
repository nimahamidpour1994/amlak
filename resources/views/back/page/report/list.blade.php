@extends('back.index')


@section('content')

    @if(count($response['reports']) > 0)
    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <td class="admin-table-hr">کد آگهی</td>
                <td class="admin-table-hr">مشکل آگهی</td>
                <td class="admin-table-hr">توضیحات بیشتر</td>
                <td class="admin-table-hr">موبایل </td>
                <td class="admin-table-hr">وضعیت</td>
                <td class="admin-table-hr">ویرایش</td>
                <td class="admin-table-hr">مشاهده آگهی</td>
            </tr>
            <tbody>
                @foreach($response['reports'] as $report)
                    <tr class="text-center font-size-13">
                        <td class="admin-info">{{$report->advertisment}}</td>
                        <td class="admin-danger">{{$report->category}}</td>
                        <td class="admin-black">{{$report->message}}</td>
                        <td class="admin-secondary">{{$report->mobile}}</td>
                        <td class="{{$report->read === 'unread' ? 'admin-danger' : 'admin-success'}}">
                            {{$report->read === 'unread' ? 'خوانده نشده' : 'خوانده شده'}}
                        </td>

                        <td>
                            <a href="{{route('admin.report.edit',$report->id)}}"
                               class="btn btn-outline-success btn-sm font-yekan">
                               ویرایش
                            </a>
                        </td>

                        <td>
                            <a href="{{route('app.show.advertisment',$report->Advertisment->slug)}}"
                               class="btn btn-outline-info btn-sm font-yekan">
                                مشاهده
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $response['reports']->links() }}
    </div>
    @else
    <div class="alert alert-warning text-right col-10 mx-auto font-yekan">موردی یافت نشد</div>
    @endif


@endsection
