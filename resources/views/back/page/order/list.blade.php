@extends('back.index')


@section('content')

    @if(count($response['orders']) > 0)
    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <td class="admin-table-hr">کد سفارش</td>
                <td class="admin-table-hr">آگهی</td>
                <td class="admin-table-hr">دسته بندی</td>
                <td class="admin-table-hr">هزینه</td>
                <td class="admin-table-hr">تاریخ سفارش</td>
                <td class="admin-table-hr">مشاهده جزئیات</td>
            </tr>
            <tbody>
                @foreach($response['orders'] as $order)
                    <tr class="text-center font-size-13">
                        <td class="admin-info">{{$order->id}}</td>
                        <td class="admin-success">
                            {{$order->advertisment}}<br/>
                            <span class="admin-info">{{optional($order->Advertisment)->name}}</span>
                        </td>
                        <td class="admin-danger">{{optional(optional($order->Advertisment)->Category)->name}}</td>
                        <td class="admin-success">{{$order->price . ' تومان '}}</td>
                        <td class="admin-secondary direction-ltr">{{jdate($order->created_at)->format('Y/m/d | H:i')}}</td>
                        <td>
                            <a href="{{route('admin.order.show',$order->id)}}"
                               class="btn btn-outline-success btn-sm font-yekan">
                           مشاهده
                            </a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $response['orders']->links() }}
    </div>
    @else
    <div class="alert alert-warning text-right col-10 mx-auto font-yekan text-center font-weight-bold">موردی یافت نشد</div>
    @endif


@endsection
