function send_code(type) {
    var mobile;

    if(type==='report')
    {
        mobile = $("input[name=report_mobile]").val();
        $('#div_code').fadeIn();
        $('#loginReport').fadeIn();
        $('#repeteReport').fadeIn();
        $('#sendCode').addClass('d-none');
        document.getElementById('mobile_show_report').innerText=mobile;

    }

    else
    {
        mobile = $("input[name=call_mobile]").val();
        $('#div_code').fadeIn();
        $('#login_call').fadeIn();
        $('#repete_call').fadeIn();
        $('#sendCode').addClass('d-none');
        document.getElementById('mobile_show_call').innerText=mobile;
    }

    $.ajax({
        url:'/Api/sendCode/'+mobile,
        method:'get',
        success:function (data) {
        }
    });

}

function login_user(type) {

    var token;
    var mobile;
    var password;
    if (type==='report')
    {
        token = $("input[name=_token]").val();
        mobile = $("input[name=report_mobile]").val();
        password = $("input[name=passwordReport]").val();
    }
    else
    {
        token = $("input[name=_token]").val();
        mobile = $("input[name=call_mobile]").val();
        password = $("input[name=passwordCall]").val();
    }


    $.ajax({
        url:'/Api/submit_login_ajax',
        method:'post',
        data:{mobile:mobile,password:password},
        success:function (data) {
            if(data==='true')
            {
                if (type==='report')
                {
                    document.getElementById('successloginReport').innerText='شما با موفقیت وارد شدید';
                    document.getElementById('btnLoginReport').classList.remove('d-block');
                    document.getElementById('btnLoginReport').classList.add('d-none');
                    document.getElementById('btnSendReport').classList.remove('d-none');
                    document.getElementById('btnSendReport').classList.add('d-block');
                    document.getElementById('report_mobile_id').readOnly=true;
                }
                else
                {
                    document.getElementById('successloginCall').innerText='شما با موفقیت وارد شدید';
                    document.getElementById('btnLoginCall').classList.remove('d-block');
                    document.getElementById('btnLoginCall').classList.add('d-none');
                    document.getElementById('btnSendCall').classList.remove('d-none');
                    document.getElementById('btnSendCall').classList.add('d-block');
                    document.getElementById('call_mobile_id').readOnly=true;
                }
            }
        }
    });
}
