@extends('back.index')

@section('content')

    <section class="direction-ltr bg-white pt-0" id="welcome">
        <div class="container-fluid my-5">
            @include('message.message')
            <form  action="{{route('admin.blog.store')}}" method="POST" enctype="multipart/form-data"
                   class="form admin-form">
                @csrf
                <div class="form-row mb-3 p-3">
                    <div class="align-right mr-2">
                        <div class="image-upload">
                            <label for="photo">
                                <span class="admin-input-label d-block">انتخاب تصویر</span>
                                <img src="{{url('/front/img/structure/image-add.png')}}" id="slideshowfileimg"
                                     class="img-thumbnail admin-form-img"/>
                            </label>
                            <input type="file" name="thumbnail" id="photo" onchange="readURL(this);"
                                   class="d-none">

                            <div class="d-inline-block" id="preview-img"></div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="title_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i> عنوان مطلب </label>
                        <input type="text" name="title" id="title_id" value="{{old('title')}}" class="form-control admin-input" placeholder="عنوان مطلب">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="category_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i> دسته بندی مطلب جدید  </label>
                        <select id="category_id" name="category" class="form-control admin-input">
                            @foreach($response['parent'] as $parent)
                                <option value="{{$parent->id}}" class="admin-input">{{$parent->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="description_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp; محتوا</label>
                        <textarea class="form-control admin-input p-2 content" id="description_id" name="description" placeholder="محتوا">{{old('details')}}</textarea>
                    </div>
                </div>



                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-8 col-sm-10 col-xs-10 btn admin-submit" value="ثبت مطلب" >
                </div>
            </form>
        </div>
    </section>

@endsection





@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>

    <script type="text/javascript">

        tiny();
        // **** TINY MCE
        function tiny() {
            var editor_config = {
                path_absolute : "/",
                selector: "textarea.content",
                directionality:'rtl',
                height:'350px',
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect fontselect fontsizeselect forecolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                fontsize_formats: "8px 9px 10px 11px 12px 14px 16px 18px 20px 22px 24px 36px",
                relative_urls: false,
                file_browser_callback : function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                    if (type === 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    });
                }
            };
            tinymce.init(editor_config);
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#slideshowfileimg').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection

