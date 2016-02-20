/**
 * Created by danni on 2016/2/20.
 */

$(document).ready(function(){
    $("#new_pwd2").blur(function(){
        var $new_pwd = $("#new_pwd").val();
        var $new_pwd2 = $("#new_pwd2").val();
        if($new_pwd != $new_pwd2){
            $("#respond").show();
            //document.getElementById("rset").isDisabled = true;
            $("#rset").attr("disabled", true);


        }else{
            $("#respond").hide();
            //document.getElementById("rset").isDisabled = false;
            $("#rset").attr("disabled", false);
            return true;
        }
    });
});

$(document).ready(function(){
    $("#rset").click(function(){
        if ($("#new_pwd").val()==""){
            $("#rset").attr("disabled", true);
        }else
        {
            $("#pwdform").submit();
        }
    });
});