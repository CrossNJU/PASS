/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    showHint();
});

function showHint(){
    $("input[name!='send'][id!='msg'][id!='type'],textarea,select").after("<span class='hint'></span>");
}


function checkEmail(){
    var result = true;

    var email = $("#email-address").val();

    var valiResult;
    $(".hint").html("");

    if (valiResult = validate_email(email)){
        $("input[id='email-address']").next(".hint").html(valiResult);
        result = false;
    }
    return result;
}
function show(){
    var $p1 = $("#msg").val();
    var $p2 = $("#type").val();
    if ($p1!=""){
        showStateBar($p2,$p1);
    }
}