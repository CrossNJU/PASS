/**
 * Created by danni on 2016/2/20.
 */

function checkReset(){
    var p1 = document.getElementById("new_pwd").value;
    var p2 = document.getElementById("new_pwd2").value;

    if(p1 == "" || p1 == null){
        showStateBar("danger","请输入新密码");
        return false;
    }
    if(p2 == "" || p2 == null){
        showStateBar("danger","请再次输入密码");
        return false;
    }
    if(p1 != p2){
        showStateBar("danger","两次密码输入不一致");
        return false;
    }
    return true;
}