@if($errors->any())
    <div class="alert alert-danger">
        <ul class="direction-rtl text-right">
        @foreach($errors->all() as $error)
            <li>
                {{$error}}
            </li>
        @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success direction-rtl font-size-14 font-yekan text-right bold"> {{session('success')}}</div>
@endif

@if(session('warning'))
    <div class="alert alert-danger direction-rtl font-size-14 font-yekan text-right bold"> {{session('warning')}}</div>
@endif
