/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    //var email = $("#email-address").val();
    //$('#mail-send').click(function(){
    //    if ( validate_null(email)){
    //        $("#mail-attention-null").show();
    //        $("#mail-send").attr("disabled", true);
    //    }else
    //    {
    //        $("#mail-send").attr("disabled", false);
    //        $("#pwd-find-mail").submit();
    //    }
    //
    //})
})

function checkEmail(){
    var email = $("#email-address").val();
    if ( validate_null(email)){
        $("#mail-attention-null").show();
        return false;
    }else
    {
        $("#mail-attention-null").hide();
        return true;
    }
}