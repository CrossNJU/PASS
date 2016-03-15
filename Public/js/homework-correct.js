/**
 * Created by Lenovo on 2016/3/16.
 */
$(document).ready(function (){
    showHint();
});

function showHint(){
    $(".card-right .comment").append("<span class='hint'></span>");
}

function validate(){
    var result = true;
    var validateResult;
    var comment = $("textarea[name='comment']").val();
    var mark = $("input[name='mark']").val();

    if(validateResult = validate_null(comment)){
        showValidateError();
        $(".comment:contains('评语')").children(".hint").html(validateResult);
        result = false;
    }

    if(validateResult = validate_num(mark,0,100)){
        showValidateError();
        $(".comment:contains('评分')").children(".hint").html(validateResult);
        result = false;
    }

    return result;
}