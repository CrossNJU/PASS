/**
 * Created by Lenovo on 2016/2/25.
 */

function checkEmail(){
    var email = $("#email-address").val();
    if ( validate_null(email)){
        showStateBar("danger","请填写邮箱")
        return false;
    }else if(!validate_email(email)){
        showStateBar("danger","邮箱格式好像哪里不对")
        return false;
    }
    return true;
}
function show(){
    var $p1 = $("#msg").val();
    var $p2 = $("#type").val();
    if ($p1!=""){
        showStateBar($p2,$p1);
    }
}