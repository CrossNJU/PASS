/**
 * Created by danni on 2016/2/21.
 */
$(document).ready(function(){
    $('#loginbtn').click(function() {
        //var remember = $('#rememberMe').is(':checked') ? true : false;
        var id = $('#login-id').val();
        var password = $('#login-pwd').val();
    });
});

function show(){
    var $p1 = $("#msg").val();
    var $p2 = $("#type").val();
    if ($p1!=""){
        showStateBar($p2,$p1);
    }
}
