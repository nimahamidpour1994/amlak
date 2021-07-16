@extends('back.index')


@section('content')

    @if(count($response['order_detail']) > 0)
    <div class="table-responsive admin-div-table">
        <table class="table table-striped">
            <tr class="admin-table-hr-row">
                <td class="admin-table-hr">کد سفارش</td>
                <td class="admin-table-hr">عنوان طرح</td>
                <td class="admin-table-hr">مبلغ</td>
                <td class="admin-table-hr">وضعیت</td>
                <td class="admin-table-hr">تاریخ</td>
            </tr>
            <tbody>
                @foreach($response['order_detail'] as $order_detail)
                    <tr class="text-center font-size-13">
                        <td class="admin-info">{{$order_detail->order}}</td>
                        <td class="admin-success">
                            @if($order_detail->plan === 'ladder')
                                نـردبان
                            @elseif($order_detail->plan === 'urgent')
                                فـوری
                            @elseif($order_detail->plan === 'extension')
                                تـمدید
                            @elseif($order_detail->plan === 'listen_bell')
                                گـوش به زنگ
                            @endif
                        </td>
                        <td class="admin-danger">{{$order_detail->price. ' تومان '}}</td>
                        <td class="{{$order_detail->pay === 'paid'?  'admin-success':'admin-danger'}}">{{$order_detail->pay === 'paid'?  'پرداخت شده':'پرداخت نشده'}}</td>
                        <td class="admin-secondary direction-ltr">{{jdate($order_detail->created_at)->format('Y/m/d | H:i')}}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-warning text-right col-10 mx-auto font-yekan text-center font-weight-bold">موردی یافت نشد</div>
    @endif


@endsection
