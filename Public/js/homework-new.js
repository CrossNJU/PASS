/**
 * Created by Lenovo on 2016/2/16.
 */
$(document).ready(function (){
    showHint();
    var options = $("select[name='type']").children("option");
    $.each(options,function(n,option) {
        if($(option).val() == homeworkType){
            $(option).attr("selected",true);
        }
    });
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
        console.log("title");
        result = false;
        showValidateError();
        $("input[name='title']").next(".hint").html(valiResult);
    }

    if(valiResult = validate_time(startTime,endTime)){
        console.log("time");
        result = false;
        showValidateError();
        $("input[name='endTime']").next().next().next(".hint").html(valiResult);
    }

    if(valiResult = validate_null(require)) {
        console.log("requi");
        result = false;
        showValidateError();
        $("textarea[name='requi']").next(".hint").html(valiResult);
    }

    return result;
}