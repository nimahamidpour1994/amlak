$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function showdeleteimg(parent) {
    parent.src='/front/img/structure/delete.svg';
}

function showthisimg(parent,url) {
    parent.src='/storage/advertisment/thumbnail/'+url;
}

function deleteimg(parent,src) {

    $.ajax({
        url: "/Api/Image/delete",
        type: 'POST',
        data: {src: src},
        success:function (data) {
            if (data === 'true')
            {
                parent.remove();
            }

        }
    });
}
