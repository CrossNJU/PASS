/**
 * Created by Lenovo on 2016/2/16.
 */
$(document).ready(function (){
   showHint();
});

function showHint(){
    $("input[name!='startTime'][name!='save'],textarea,select").after("<span class='hint'></span>");
}

function validate(){
    var result = true;

    var title = $("input[name='title']").val();
    var startTime = $("input[name='startTime']").val();
    var endTime = $("input[name='endTime']").val();
    var require = $("textarea[name='requi']").val();

    var valiResult;
    $(".hint").html("");

    if(valiResult = validate_null(title)){
        showValidateError();
        $("input[name='title']").next(".hint").html(valiResult);
        result = false;
    }

    if(valiResult = validate_time(startTime,endTime)){
        showValidateError();
        $("input[name='endTime']").next(".hint").html(valiResult);
        result = false;
    }

    if(valiResult = validate_null(require)) {
        showValidateError();
        $("textarea[name='requi']").next(".hint").html(valiResult);
        result = false;
    }

    return result;
}