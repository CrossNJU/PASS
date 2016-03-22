/**
 * Created by Lenovo on 2016/3/5.
 */
$(document).ready(function(){
    showHint();
});

function showHint(){
    $("input[name!='register'][id!='msg'][id!='type'],textarea,select").after("<span class='hint'></span>");
}

function checkRegister(){

    var result = true;

    var stu_id = document.getElementById("add_id").value;
    var stu_name = document.getElementById("add_name").value;
    var stu_aca = $('#tea_aca  option:selected').text();
    var stu_spe = $('#tea_spe  option:selected').text();
    var stu_grade = $('#add_grade  option:selected').text();
    var stu_email = document.getElementById("add_email").value;
    var stu_phone = document.getElementById("add_phone").value;
    var stu_pwd = document.getElementById("add_pwd").value;

    var valiResult;
    $(".hint").html("");

    if(valiResult = validate_null(stu_id)){
        showValidateError();
        $("input[id = 'add_id']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(stu_name)){
        showValidateError();
        $("input[id = 'add_name']").next(".hint").html(valiResult);
        result = false;
    }

    if(valiResult = validate_aca(stu_aca)){
        showValidateError();
        $("select[id = 'tea_aca']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_spe(stu_spe)){
        showValidateError();
        $("select[id = 'tea_spe']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_grade(stu_grade)){
        showValidateError();
        $("select[id = 'add_grade']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_email(stu_email)){
        showValidateError();
        $("input[id = 'add_email']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_phone(stu_phone)){
        showValidateError();
        $("input[id = 'add_phone']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(stu_pwd)){
        showValidateError();
        $("input[id = 'add_pwd']").next(".hint").html(valiResult);
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