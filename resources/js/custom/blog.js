
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function suggest_search_blog() {
    var search=$('#search_text_id').val();

    if (search.length > 3)
    {
        $.ajax({
            url:'/Api/Blog/search',
            method:'post',
            data:{search:search},
            success:function (data) {
                if (data!=='')
                {
                    $('#aj_search_content').html(data)
                                           .append('<div class="mt-2">' +
                                               '<input type="submit" value="مـشاهده همه نتایج" class="btn mx-auto text-center text-dark font-yekan font-size-14 text-decoration-none" href="search/'+search+'"/> </div>');
                }
                else
                {
                    $('#aj_search_content').html('<div class="alert alert-warning text-center font-size-14">موردی یافت نشد</div>');
                }
            }
        });
    }
    else
    {
        $('#aj_search_content').html('');
    }
}

function suggest_search_blog_mobile() {
    var search=$('#search_text_mobile_id').val();

    if (search.length > 3)
    {
        $.ajax({
            url:'/Api/Blog/search',
            method:'post',
            data:{search:search},
            success:function (data) {
                if (data!=='')
                {
                    $('#aj_search_content_mobile').html(data).append('<div class="mt-2">' +
                        '<input type="submit" value="مـشاهده همه نتایج" class="btn btn-light text-black form-control mx-auto text-center text-dark font-yekan font-size-14 text-decoration-none" href="search/'+search+'"/> </div>');
                    ;
                }
                else
                {
                    $('#aj_search_content_mobile').html('<div class="alert alert-warning text-center font-size-14">موردی یافت نشد</div>');
                }
            }
        });
    }
    else
    {
        $('#aj_search_content_mobile').html('');
    }
}


function likeComment(id) {
    $.ajax({
        url:'/Api/Comment/like',
        method:'post',
        data:{comment:id},
        dataType:'json',
        success:function (data)
        {
            if (data['msg'] === 'success')
            {
                document.getElementById('like'+id).innerText=data['count'];
            }
        }
    });
}

function dislikeComment(id) {
    $.ajax({
        url:'/Api/Comment/dislike',
        method:'post',
        data:{comment:id},
        dataType:'json',
        success:function (data)
        {
            if (data['msg'] === 'success')
            {
                document.getElementById('dislike'+id).innerText=data['count'];
            }
        }
    });
}
