// ***************************************** MAIN PAGE  ******************************************

var loading = false;
var oldscroll = 0;
var limit=20;
var counter=1;
var condition=[];
var finalcondition=[];

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//  LOAD ADVERTISMENT
function  load_data() {

    $.ajax({
        url:'/Api/moreAdvertisment',
        method:'post',
        data:{counter:counter,limit:limit,conditions:condition},
        success:function (data) {
            if(data!=='')
            {
                if (counter===0)
                {
                    $('#load_data').html(data);
                }
                else
                {
                    $('#load_data').append(data);
                }
                counter++;
                loading=false;
            }
            else
            {
                if(counter===0)
                    $('#load_data').html('<div class="col-12 bold text-center alert alert-warning">متاسفانه نتیجه ای یافت نشد</div>');
                loading=true;
            }

            document.getElementById('loading').classList.remove('d-block');
            document.getElementById('loading').classList.add('d-none');
        }
    });
}

// LAZY LOAD WITH SCROLL MOUSE
function lazyload() {
    $(window).scroll(function () {
        if ($(window).scrollTop() > oldscroll) {
            if (($(window).scrollTop() + $(window).height() >= $(document).height()-600)) {
                if (!loading)
                {
                    loading=true;
                    oldscroll=$(window).scrollTop();
                    load_data();
                    document.getElementById('loading').classList.remove('d-none');
                    document.getElementById('loading').classList.add('d-block');
                }
            }
        }
    });
}

// RESET PARAMETR
function resetParametr() {
    counter=0;
    $(window).scrollTop(0);
    oldscroll=0;

    $('#filterBox').html('');
    $('#haveimg').prop('checked',false);
    $('#haveurgent').prop('checked',false);
    $('#who').val('');

    $('#haveimg-mobile').prop('checked',false);
    $('#haveurgent-mobile').prop('checked',false);
    $('#who-mobile').val('');
    $('.mobile-filter').remove();
}

// SEARCHBOX
function loadSubCategoryName(node_id) {
    if(node_id===1)
    {
        $('#btn_search_span').text('همه آگهی ها');
        var app_name=$('#hidden_name').val();
        var app_issue=$('#hidden_issue').val();
        $('#category_help_status').text(app_name + ' - ' + app_issue);
    }
    else
    {
        $.ajax({
            url:'/Api/SubCategoryName',
            method:'post',
            data:{id:node_id},
            dataType:'json',
            success:function (data) {
                if(data!=='')
                {
                    if (data['name']!=='')
                    {
                        $('#btn_search_span').text(data['name']);
                        $('#category_help_status').text(data['name']);
                    }

                }

            }
        });
    }

}

// CHANGE STATE WHEN CITY CHANGED
function changeState() {
    var parent = $('#city').val();
    $.ajax({
        url: '/Api/changeState',
        method: 'post',
        data: {parent: parent},
        dataType: 'json',
        success: function (data) {
            document.getElementById('state').innerHTML = '';
            for (var i = 0; i < data.length; i++) {
                var option = document.createElement('option');
                option.value = data[i]['id'];
                option.innerText = data[i]['name'];
                document.getElementById('state').appendChild(option);
            }
        }
    });
}

// CHANGE CITY
function changeCity(){

    var city= $('#City_id').val();

    $.ajax({
        url:'/Api/changeCity',
        method:'post',
        data:{city:city},
        success:function (data) {
            window.location.reload();
        }
    });
}

// ADD MARK FOR BOOKMARKS
function addMark(parent,advertisment) {
    $.ajax({
        url: "/Api/mark/store",
        type: 'POST',
        data: {advertisment: advertisment},
        success:function (data)
        {
            if (data === 'success')
            {
                parent.classList.remove('btn-outline-secondary');
                parent.classList.add('bg-danger');
                parent.classList.add('text-white');
                parent.value='نشان شده';
                parent.disabled=true;
            }
        }
    });
}

// COPY LINK ADVERTISMENT
function sharelink(id) {
    var copyText = document.getElementById(id);
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/
    copyText.title='گپی شد';
    /* Copy the text inside the text field */
    document.execCommand("copy");
    Swal.fire({
        position: 'center',
        type: 'success',
        title: 'لینک آگهی ذخیره گردید',
        showConfirmButton: false,
        timer: 3000
    });
}

// CONVERT 3 DIGIT NUMBER
function digitGroup(price, id,unit) {
    var value = price.value;
    var output = "";
    try {
        value = value.replace(/[^0-9]/g, ""); // remove all chars including spaces, except digits.
        var totalSize = value.length;
        for (var i = totalSize - 1; i > -1; i--) {
            output = value.charAt(i) + output;
            var cnt = totalSize - i;
            if (cnt % 3 === 0 && i !== 0) {
                output = "/" + output; // seperator is " "
            }
        }
    } catch (err) {
        output = value; // it won't happen, but it's sweet to catch exceptions.
    }
    document.getElementById(id).innerHTML = output + ' '+ unit;
}

// SHOW MORE FIELD IN ADD OR EDIT ADVERTISMENT WHEN CLICK AGENT
function show_more_field(type) {
    if(type==='agent')
    {
        $('#agent_form').fadeIn();
    }
    else
    {
        $('#agent_form').fadeOut();
    }
}

// REPORT
function send_report() {

    var advertisment=$("input[name=advertisment_id]").val();
    var mobile=$("input[name=report_mobile]").val();
    var message=$("#report_details").val();
    var category=$("#report_type").val();

    if(category !== '')
    {
        $.ajax({
            url:'/Api/report/store',
            method:'post',
            data:{advertisment:advertisment,mobile:mobile,message:message,category:category},
            success:function (data) {
                if(data==='success')
                {
                    $('#success_report').removeClass('d-none');
                }
            }
        });
    }
    else
    {
        $('#report_type').addClass('border border-danger');
    }

}

