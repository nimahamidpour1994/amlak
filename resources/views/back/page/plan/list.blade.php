@extends('back.index')


@section('content')
    @include('message.message')
        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <th class="admin-table-hr">عنوان</th>
                    <th class="admin-table-hr">انقضا</th>
                    <th class="admin-table-hr">قیمت</th>
                    <th class="admin-table-hr">ویرایش</th>
                </tr>
                <tbody>

                @foreach($response['plans'] as $plan)
                    <tr class="text-center font-size-15">
                        <td class="admin-black">{{$plan->title}}</td>
                        <td class="admin-danger">{{$plan->expire. ' روز '}}</td>
                        <td class="admin-success">{{number_format($plan->price).' تومان '}}</td>
                        <td>
                            <a href="{{route('admin.plan.edit',$plan->id)}}" class="btn btn-outline-primary btn-sm font-yekan">
                               ویرایش
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>


@endsection
