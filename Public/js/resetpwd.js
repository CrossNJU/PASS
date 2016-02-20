/**
 * Created by danni on 2016/2/20.
 */

function check(){
        var new_pwd = document.getElementById("new_pwd").value;
        var new_pwd2 = document.getElementById("new_pwd2").value;
        if(new_pwd != new_pwd2){
            alert("两次密码不同");
            //document.getElementById("respond").innerHTML="两次密码不一致"
            if(event.preventDefault()){
                event.preventDefault();
            }else{
                event.returnValue = false;
            }
        }else{
            return true;
        }
}
