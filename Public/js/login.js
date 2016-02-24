/**
 * Created by danni on 2016/2/21.
 */
$(document).ready(function(){
    $('#loginbtn').click(function() {
        //var remember = $('#rememberMe').is(':checked') ? true : false;
        var id = $('#login-id').val();
        var password = $('#login-pwd').val();

        $.ajax({
            type: 'post',
            url: "http://localhost/PASS/index.php/Home/Common/login",
            dataType: 'json',
            data:{login:$('#loginbtn').val(),id:id,pwd:password},
            success: function(json) {
                switch (json) {
                    case 1: // 登录成功
                        var text = "登录成功";
                        $.toaster({ title : text, priority : 'success', message : '' });
                        $('.log-or-sign').hide();
                        setTimeout(function() {
                            window.location.reload()
                        },1200);
                        break;
                    case 0: // 密码错误
                        alert("密码错误");
                        $('#login-pwd').focus();
                        break;
                    case -1: // 用户不存在
                        alert("用户名不存在");
                        //var text = "用户不存在，请重新输入或注册新用户";
                        //$('#login-info').show();
                        //$('#login-info').html(text);
                        $('#login-id').focus();
                        break
                }
            }
        });
    });
});