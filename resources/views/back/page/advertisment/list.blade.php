@extends('back.index')


@section('content')
    @include('message.message')


         <form action="{{route('admin.advertisment.search')}}" method="POST">
             @csrf
             <div class="form-row pt-4 pb-3">
                 <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 direction-ltr mx-3">
                     <div class="input-group">

                         <div class="input-group-prepend cursor-pointer">
                               <button type="submit" class="px-3 text-center search_box rounded-0" style="background: #ededed!important;">
                                      <i class="fas fa-search text-dark text-center" aria-hidden="true"></i>
                               </button>
                         </div>
                         <input type="text" class="form-control my-0 py-1 text-right fa-num font-size-12 search_box shadow-none border-left-0 direction-rtl"
                                style="height: 50px"  id="key"  name="key"
                                placeholder="کد ملک، شماره تماس">
                         <div class="input-group-append direction-rtl text-right d-none d-xl-block d-lg-block">
                             <select name="category" id="category"
                                     class="form-control-sm fa-num font-size-14 shadow-none text-dark"
                                     style="height: 50px;background-color: #ededed">
                                 <option value="" class="text-divar bold">همه دسته ها</option>
                                 @foreach($response['cats'] as $cat)
                                     <option class="mobile-btn text-dark font-size-14 font-yekan" data-toggle="modal" data-target="#modal_filter"
                                             value="{{$cat['id']}}"
                                             id="btn{{$cat['id']}}">
                                         {{$cat['name']}}
                                     </option>
                                 @endforeach
                             </select>
                         </div>

                     </div>
                 </div>
             </div>
         </form>

        <div class="table-responsive admin-div-table">
            <table class="table table-striped">
                <tr class="admin-table-hr-row">
                    <td class="admin-table-hr">نام آگهی</td>
                    <td class="admin-table-hr">دسته بندی</td>
                    <td class="admin-table-hr">تاریخ ثبت</td>
                    <td class="admin-table-hr"> شماره تلفن</td>
                    <td class="admin-table-hr">پیش نمایش</td>
                    <td class="admin-table-hr">ویرایش آگهی</td>
                    <td class="admin-table-hr">حذف</td>
                    <td class="admin-table-hr">سایر آگهی ها</td>
                </tr>
                <tbody>
                @foreach( $response['advertisments'] as $advertisment)
                    <tr class="text-center font-size-14">
                        <td class="admin-black">{{$advertisment->name}}</td>
                        <td class="admin-info">{{$advertisment->Category->name}}</td>
                        <td class="admin-danger direction-ltr">{{jdate($advertisment->created_at)->format('Y.m.d | H:i')}}</td>
                        <td class="admin-black">{{$advertisment->mobile}}</td>

                        <td><a href="{{route('admin.advertisment.preview',$advertisment->id)}}" class="btn btn-outline-info  btn-sm font-yekan">پیش نمایش</a></td>
                        <td><a href="{{route('admin.advertisment.edit',$advertisment->id)}}" class="btn btn-outline-primary  btn-sm font-yekan">ویرایش</a></td>
                        <td><a href="{{route('admin.advertisment.destroy',$advertisment->id)}}" class="btn btn-outline-danger  btn-sm font-yekan">حذف</a></td>
                        <td><a href="{{route('admin.advertisment.list',$advertisment->mobile)}}" class="btn btn-outline-secondary  btn-sm font-yekan">سایر آگهی ها</a></td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $response['advertisments']->links() }}
        </div>


@endsection

