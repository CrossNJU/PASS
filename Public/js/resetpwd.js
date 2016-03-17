/**
 * Created by danni on 2016/2/20.
 */
$(document).ready(function(){
    showHint();
});

function showHint(){
    $("input[name!='register'],textarea,select").after("<span class='hint'></span>");
}


function checkReset(){
    var result = true;

    var p1 = document.getElementById("new_pwd").value;
    var p2 = document.getElementById("new_pwd2").value;

    var valiResult;
    $(".hint").html("");

    if(valiResult = validate_null(p1)){
        showValidateError();
        $("input[id = 'new_pwd']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(p2)){
        showValidateError();
        $("input[id = 'new_pwd2']").next(".hint").html(valiResult);
        result = false;
    }
    if(p1 != p2){
        showValidateError();
        $("input[id = 'new_pwd2']").next(".hint").html("两次密码不一致");
        result = false;
    }

    return result;
}