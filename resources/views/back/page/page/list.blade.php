@extends('back.index')


@section('content')
        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <th class="admin-table-hr">عنوان</th>
                    <th class="admin-table-hr">ویرایش</th>
                </tr>
                <tbody>
                @php $i=1; @endphp
                @foreach($response['pages'] as $page)
                    <tr class="text-center font-size-15">
                        <td class="admin-black">{{$page->name}}</td>
                        <td class="fa-num">
                            <a href="{{route('admin.page.edit',$page->id)}}" class="btn btn-outline-info btn-sm font-yekan">
                               ویرایش
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>



@endsection
