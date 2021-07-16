var i=0;
var offset=0;
var site='http://amlakesfahan.com/storage/advertisment/thumbnail/';

function setimage(parent) {

    Array.from(parent.files).forEach(file => {
        if (i<15) {
            var _URL = window.URL || window.webkitURL;
            img = new Image();
            var objectUrl = _URL.createObjectURL(file);
            img.onload = function () {
                if (this.width > 600 || this.height > 600) {

                    // CREATE DIV BACKGROUND IMG
                    var divimg = document.createElement('div');
                    divimg.style.backgroundImage = "url('" + objectUrl + "')";
                    divimg.classList.add('image-item__image');

                    // CREATE DIV BACKGROUND COLOR
                    var divprogres = document.createElement('div');
                    divprogres.classList.add('image-item__progress');
                    divprogres.classList.add('fa-num');
                    divprogres.innerHTML = "100%";

                    divimg.append(divprogres);

                    // CREATE DIV PARENT OF DIV BACKGROUND IMG
                    var parent = document.createElement('div');
                    parent.classList.add('image-item');
                    parent.setAttribute('role', 'button');
                    parent.append(divimg);

                    parent.onclick = function () {
                        $(".image-item").not(this).removeClass('isMainImage');
                        $(this).toggleClass('isMainImage');
                    };

                    // APPEND ALL
                    $('#preview-img').append(parent);


                    // SEND FILE
                    var formData = new FormData();
                    formData.append('file', file);
                    divprogres.innerHTML = "28%";
                    setTimeout(function () {
                        divprogres.innerHTML = "71%";
                        $.ajax({
                            url: "/Api/Image/save",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: "json",
                            success: function (data) {
                                if (data['message'] === 'success')
                                {
                                    divprogres.innerHTML = "100%";

                                    // CREATE BTN DELETE
                                    var btndelete=document.createElement('div');
                                    btndelete.classList.add('image-item__delete-btn');
                                    btndelete.innerHTML='<i class="far fa-trash-alt font-size-20"></i>';

                                    divimg.innerHTML = '';
                                    divimg.append(btndelete);
                                    // CREATE BTN DELETE

                                    //  DELETE FUNCTION
                                    btndelete.onclick=function () {

                                        $.ajax({
                                            url: "/Api/Image/delete",
                                            type: 'POST',
                                            data: {src: data['src']},
                                            success:function (data)
                                            {
                                                if (data==='true')
                                                {
                                                    parent.remove();
                                                    if (i===16)
                                                    {
                                                        $('#uploaded_file').removeClass('d-none');
                                                    }
                                                    i--;
                                                }
                                            }
                                        });
                                    };
                                    //  DELETE FUNCTION

                                    // CHANGE SRC IMG
                                    divimg.style.backgroundImage = "url('" + site+data['src'] + "')";
                                    // CHANGE SRC IMG

                                    // COUNTER IMG
                                    i++;

                                    // DISABLE UPLOAD INPUT
                                    if (i > 15) {
                                        $('#uploaded_file').addClass('d-none');
                                    }
                                    // DISABLE UPLOAD INPUT
                                }
                                else
                                {
                                    divprogres.innerHTML = "خطا در بارگذاری";
                                    setTimeout(function () {
                                        parent.innerHTML = '';
                                    }, 2000);
                                }

                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                    },offset);
                    offset+=1000;
                }
                else
                {
                    // SIZE MIN
                    var lierror=document.createElement('li');
                    lierror.classList.add('content');
                    lierror.classList.add('text-right');
                    lierror.style.fontSize="0.85em";
                    lierror.innerText=file['name']+" بارگذاری نشد. اندازه عکس بسیار کوچک است (حداقل ۶۰۰ در ۶۰۰ پیکسل)";

                    $('#errorul').append(lierror);
                    $('#errormain').removeClass('d-none');

                    setTimeout(function () {
                        $('#errormain').addClass('d-none');
                    },7000);
                }
            };
            img.src = objectUrl;
        }
    });
}

function uploadedimageclick(parent) {
    $(".image-item").not(parent).removeClass('isMainImage');
    $(parent).toggleClass('isMainImage');

}

function uploadedimagedelete(src) {
    $.ajax({
        url: "/Api/Image/delete",
        type: 'POST',
        data: {src: src},
        success:function (data)
        {
            if (data==='true')
            {
                document.getElementById('img'+src).remove();

                if (i===16)
                {
                    $('#uploaded_file').removeClass('d-none');
                }
                i--;
            }
        }
    });
}
