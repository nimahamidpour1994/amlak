@extends('back.index')


@section('content')

    <section class="direction-ltr bg-white pt-0" id="welcome">
        <div class="container-fluid my-5">
            @include('message.message')
            <form  action="{{route('admin.setting.update',1)}}" enctype="multipart/form-data"
                   method="POST" class="form admin-form">
                @csrf

                <div class="form-row mb-3 p-3">
                    <div class="align-right mr-2">
                        <div class="image-upload">
                            <label for="photo">
                                <span class="admin-input-label d-block">انتخاب تصویر</span>
                                <img src="{{isset($response['app_logo']) ? url( $response['app_logo']): url('/front/img/structure/image-add.png') }}" id="slideshowfileimg"
                                     class="admin-form-img" style="height:110px;width: 110px;margin: 10px"/>
                            </label>
                            <input type="file" name="photo" id="photo" onchange="readURL(this);"
                                   class="d-none" value="{{isset($response['app_logo']) ? url( $response['app_logo']) : '' }}">
                        </div>
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="title_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;عنوان سایت</label>
                        <input type="text" class="form-control admin-input  @error('title') is-invalid @enderror"
                               id="title_id" name="title" placeholder="عنوان سایت"
                               value="{{$response['app_name']!='' ? $response['app_name'] : ''}}">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="issue_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;موضوع سایت</label>
                        <input type="text" class="form-control admin-input  @error('issue') is-invalid @enderror"
                               id="issue_id" name="issue" placeholder="موضوع سایت"
                               value="{{$response['app_issue']!='' ? $response['app_issue'] : ''}}">
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4">
                        <label for="tell_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp; تلفن تماس<span class="font-size-14 text-danger"> (با - از هم جدا کنید) </span></label>
                        <input type="text" class="form-control admin-input  @error('tell') is-invalid @enderror"
                               id="tell_id" name="tell" placeholder="تلفن تماس"
                               value="{{$response['app_tell']!='' ? $response['app_tell'] : ''}}">
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="address_id" class="admin-input-label"><i
                                class="fas fa-pencil-alt prefix text-right"></i>&nbsp;آدرس</label>
                        <textarea class="form-control p-3 admin-input @error('address') is-invalid @enderror" id="address_id"
                                  name="address" placeholder="آدرس"
                                  style="height: 75px">{{$response['app_address']!='' ? $response['app_address'] : ''}}</textarea>
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="police_fata" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp; پیام پلیس فتا </label>
                        <textarea class="form-control admin-input p-2" id="police_fata"
                                  name="police_fata" placeholder="پیام پلیس فتا">{{$response['police_fata']!='' ? $response['police_fata'] : ''}}</textarea>
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="app_warning" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp; هشدار آگهی</label>
                        <textarea class="form-control admin-input p-2" id="app_warning"
                                  name="app_warning" placeholder="هشدار آگهی">{{$response['app_warning']!='' ? $response['app_warning'] : ''}}</textarea>
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4">
                        <label for="blog_footer" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp; توضیحات پایین صفحه بلاگ </label>
                        <textarea class="form-control admin-input p-2" id="blog_footer"  style="height: 150px"
                                  name="blog_footer" placeholder="توضیحات پایین صفحه بلاگ">{{$response['blog_footer']!='' ? $response['blog_footer'] : ''}}</textarea>
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mb-4 ">
                        <label for="description_id" class="admin-input-label"><i class="fas fa-pencil-alt prefix text-right"></i>&nbsp; درباره ما</label>
                        <textarea class="form-control admin-input  p-2 content" id="description_id" name="description" placeholder="درباره ما">{{$response['app_description']!='' ? $response['app_description'] : ''}}</textarea>
                    </div>
                </div>


                <div class="form-row my-4">
                    <input type="submit" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 btn admin-submit" value="ویرایش">
                </div>

            </form>
        </div>
    </section>


@endsection


@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
    <script>

        tiny();


        // **** TINY MCE
        function tiny() {
            var editor_config = {
                path_absolute : "/",
                selector: "textarea.content",
                directionality:'rtl',
                height:'350px',
                plugins: [
                    "advlist autolink lists  charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime  nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],//image media link
                toolbar: "insertfile undo redo | styleselect fontselect fontsizeselect forecolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                fontsize_formats: "8px 9px 10px 11px 12px 14px 16px 18px 20px 22px 24px 36px",
                relative_urls: false,
                file_browser_callback : function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
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



        // **** PRIVIEW IMAGE
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
