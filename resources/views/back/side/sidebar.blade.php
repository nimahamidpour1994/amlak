<!-- Sidebar -->
<ul class="sidebar navbar-nav p-0 m-0 bg-admin sidebar-width" id="menuul">

    <li class="nav-item active">

        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="{{route('admin.dashboard')}}">
            <i class="fas fa-home  d-none d-xl-inline-block d-lg-inline-block"></i>
            <span class="font-yekan">داشبورد</span></a>
    </li>

    <!-- CATEGORY -->
    <li class="nav-item">

        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-layer-group text-white d-none d-xl-inline-block d-lg-inline-block"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i> دسته بندی </span>
        </a>

        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">
            <a class="nav-link text-right text-dark" href="{{route('admin.category.list')}}" >
                <i class="fas fa-list"></i>
                <span class="font-yekan font-weight-bold">لیست دسته ها</span>
            </a>
        </div>

    </li>

    <!-- PLAN AND ORDER -->
    <li class="nav-item">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-store text-white"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i>طرح ها و سفارشات</span>
        </a>
        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">

            <a class="nav-link text-right text-dark" href="{{route('admin.plan.list')}}">
                <i class="fas fa-box-open"></i>
                <span class="font-yekan font-weight-bold">لیست طرح</span>
            </a>

        </div>
    </li>

    <!-- CITY AND STATE -->
    <li class="nav-item">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-city text-white"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i>  شهر و محل</span>
        </a>
        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">

            <a class="nav-link text-right text-dark" href="{{route('admin.city.list')}}" >
                <i class="fas fa-list"></i>
                <span class="font-yekan font-weight-bold">لیست شهرها</span>
            </a>

        </div>
    </li>

    <!-- ADVERTISMENT -->
    <li class="nav-item">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ad text-white"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i> آگهی ها </span>
        </a>
        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">

            <a class="nav-link text-right text-dark" href="{{route('admin.advertisment.list','waiting')}}">
                <i class="fas fa-clock"></i>
                <span class="font-yekan font-weight-bold">صف انتــشار</span>
            </a>
            <a class="nav-link text-right text-dark" href="{{route('admin.advertisment.list','publish')}}">
                <i class="fas fa-check"></i>
                <span class="font-yekan font-weight-bold">منتــشر شده</span>
            </a>

            <a class="nav-link text-right text-dark" href="{{route('admin.advertisment.list','faild')}}">
                <i class="fas fa-times"></i>
                <span class="font-yekan font-weight-bold"> رد شده </span>
            </a>
        </div>
    </li>

    <!-- REPORT -->
    <li class="nav-item">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-flag text-white"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i> گزارش مشکل آگهی</span>
        </a>
        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">

            <a class="nav-link text-right text-dark" href="{{route('admin.report.list')}}">
                <i class="fas fa-list"></i>
                <span class="font-yekan font-weight-bold">لیست گزارشات</span>
            </a>

            <a class="nav-link text-right text-dark" href="{{route('admin.report.create')}}">
                <i class="fas fa-gavel"></i>
                <span class="font-yekan font-weight-bold">ثبت دسته جدید</span>
            </a>

        </div>
    </li>

    <!-- REPORT -->
    <li class="nav-item border-bottom pb-2">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-dollar-sign text-white"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i> گزارش مالی</span>
        </a>
        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">

            <a class="nav-link text-right text-dark" href="{{route('admin.order.list','paid')}}">
                <i class="fas fa-check"></i>
                <span class="font-yekan font-weight-bold">موارد پرداخت شده</span>
            </a>

            <a class="nav-link text-right text-dark" href="{{route('admin.order.list','unpaid')}}">
                <i class="fas fa-times"></i>
                <span class="font-yekan font-weight-bold">موارد پرداخت نشده</span>
            </a>

        </div>
    </li>

    <!-- BLOG -->
    <li class="nav-item">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-blog text-white"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i> بلاگ </span>
        </a>
        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">

            <a class="nav-link text-right text-dark" href="{{route('admin.blog.list')}}">
                <i class="fas fa-list text-black"></i>
                <span class="font-yekan font-weight-bold">لیست مطالب</span>
            </a>

            <a class="nav-link text-right text-dark" href="{{route('admin.blog.create')}}">
                <i class="fa fa-plus"></i>
                <span class="font-yekan font-weight-bold">اضافه کردن مطلب جدید</span>
            </a>

        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fab fa-google  d-none d-xl-inline-block d-lg-inline-block"></i>
            <span class="font-yekan font-size-14"> سئو <i class="fas fa-angle-down float-left"></i></span>

        </a>
        <div class="dropdown-menu p-0 m-0 position-static" aria-labelledby="pagesDropdown">
            <a href="{{route('admin.seo.list')}}" class="nav-link text-right text-dark">
                <i class="fas fa-list text-black d-none d-xl-inline-block d-lg-inline-block"></i>
                <span class="text-dark font-size-14 font-yekan font-weight-bold">لیست صفحات</span>
            </a>


        </div>
    </li>

    <!-- SETTING -->
    <li class="nav-item">
        <a class="nav-link text-right bg-admin text-white menu-padding sidebar-width" href="#" id="pagesDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-sitemap text-white"></i>
            <span class="text-white font-yekan"><i class="fas fa-angle-down float-left"></i> محتوا سایت </span>
        </a>
        <div class="dropdown-menu p-0 m-0" aria-labelledby="pagesDropdown">


            <a class="nav-link text-right text-dark" href="{{route('admin.page.list')}}">
                <i class="fas fa-question"></i>
                <span class="font-yekan font-weight-bold">دیگر صفحات سایت</span>
            </a>


            <a class="nav-link text-right text-dark" href="{{route('admin.social.list')}}">
                <i class="fab fa-instagram"></i>
                <span class="font-yekan font-weight-bold">شبکه های اجتماعی</span>
            </a>

            <a class="nav-link text-right text-dark" href="{{route('admin.setting.edit')}}">
                <i class="fas fa-mobile"></i>
                <span class="font-yekan font-weight-bold">تنظیمات سایت</span>
            </a>


        </div>
    </li>

</ul>
<!-- Sidebar -->
