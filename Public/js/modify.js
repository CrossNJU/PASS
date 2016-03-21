/**
 * Created by Lenovo on 2016/3/6.
 */

var pwd = false;

$(document).ready(function(){
    var cou_year = $("#cou_year_temp").val();
    var cou_sea = $("#cou_sea_temp").val();
    //alert(aca);
    //alert(spe);
    //$("#tea_aca option[value = aca]").attr("selected", true);
    //$("#tea_spe option[value = spe]").attr("selected", true);


    var s1 = document.getElementById("tea_aca");
    if (s1!=null)
    for(var i = 0;i < s1.length;i++){
        if(s1[i].value == aca){
            //alert("in");
            s1[i].selected = true;
            redirec(i);
            break;
        }
    }

    var s2 = document.getElementById("tea_spe");
    if (s2!=null)
    for(var i = 0;i < s2.length;i++){
        if(s2[i].value == spe){
            s2[i].selected = true;
            break;
        }
    }
    var s3 = document.getElementById("stu_grade");
    if (s3!=null)
    for(var i = 0;i < s3.length;i++){
        if(s3[i].value == grade){
            s3[i].selected = true;
            break;
        }
    }

    var syear = document.getElementById("cou_year");
    if (syear!=null)
    for(var i = 0;i < syear.length;i++){
        if(syear[i].value == cou_year){
            syear[i].selected = true;
            break;
        }
    }

    var ssea = document.getElementById("cou_sea");
    if (ssea!=null)
    for(var i = 0;i < ssea.length;i++){
        if(ssea[i].value == cou_sea){
            ssea[i].selected = true;
            break;
        }
    }

    showHint();

    $(".set-pwd").on('focus',function(){
        if (pwd == false) $(this).val("");
    });
    $(".set-pwd").on('blur',function(){
        if ($(this).val() == ""){
            pwd = false;
            $(this).val("12345678");
        }else {
            pwd = true;
        }
        console.log(pwd);
    });
});


/**
 * Created by Lenovo on 2016/3/5.
 */

function showHint(){
    $("input[name!='add'][id!='msg'][id!='type'],textarea,select").after("<span class='hint'></span>");
}

function checkTea(){

    var result = true;

    var tea_id = document.getElementById("tea_id").value;
    var tea_name = document.getElementById("tea_name").value;
    var tea_aca = $('#tea_aca  option:selected').text();
    var tea_spe = $('#tea_spe  option:selected').text();
    var tea_email = document.getElementById("tea_email").value;
    var tea_phone = document.getElementById("tea_phone").value;
    var tea_pwd = document.getElementById("tea_pwd").value;

    var valiResult;
    $(".hint").html("");

    if(valiResult = validate_null(tea_id)){
        showValidateError();
        $("input[id = 'tea_id']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(tea_name)){
        showValidateError();
        $("input[id = 'tea_name']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_aca(tea_aca)){
        showValidateError();
        $("select[id = 'tea_aca']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_spe(tea_spe)){
        showValidateError();
        $("select[id = 'tea_spe']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_email(tea_email)){
        showValidateError();
        $("input[id = 'tea_email']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(tea_phone)){
        showValidateError();
        $("input[id = 'tea_phone']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(tea_pwd)){
        showValidateError();
        $("input[id = 'tea_pwd']").next(".hint").html(valiResult);
        result = false;
    }
    if (pwd == false){
        $(".set-pwd").attr('disabled',true);
    }
    return result;
}

function checkStu(){

    var result = true;

    var stu_id = document.getElementById("stu_id").value;
    var stu_name = document.getElementById("stu_name").value;
    var stu_aca = $('#tea_aca  option:selected').text();
    var stu_spe = $('#tea_spe  option:selected').text();
    var stu_grade = $('#stu_grade  option:selected').text();
    var stu_email = document.getElementById("stu_email").value;
    var stu_phone = document.getElementById("stu_phone").value;
    var stu_pwd = document.getElementById("stu_pwd").value;

    var valiResult;
    $(".hint").html("");

    if(valiResult = validate_null(stu_id)){
        showValidateError();
        $("input[id = 'stu_id']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(stu_name)){
        showValidateError();
        $("input[id = 'stu_name']").next(".hint").html(valiResult);
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
        $("select[id = 'stu_grade']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_email(stu_email)){
        showValidateError();
        $("input[id = 'stu_email']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(stu_phone)){
        showValidateError();
        $("input[id = 'stu_phone']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(stu_pwd)){
        showValidateError();
        $("input[id = 'stu_pwd']").next(".hint").html(valiResult);
        result = false;
    }
    if (pwd == false){
        $(".set-pwd").attr('disabled',true);
    }
    return result;
}

function checkLesson(){

    var result = true;

    var cou_name = document.getElementById("cou_name").value;
    var cou_tea = document.getElementById("cou_tea").value;
    var cou_year = $('#cou_year  option:selected').text();
    var cou_sea = $('#cou_sea  option:selected').text();
    var cou_num = document.getElementById("cou_num").value;
    var cou_des = document.getElementById("cou_des").value;
    var time = true;
    var valiResult;
    $(".hint").html("");

    if(valiResult = validate_null(cou_name)){
        showValidateError();
        alert(valiResult);
        $("input[name = 'title']").next(".hint").html(valiResult);
        //$("input[name = 'title']").css("display","none");
        //document.getElementById("cou_name").style.visibility = 'hidden';
        result = false;
    }
    if(valiResult = validate_null(cou_tea)){
        showValidateError();
        $("input[id = 'cou_tea']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_year(cou_year)){
        showValidateError();
        //$("input[id = 'cou_year']").next(".hint").html(valiResult);
        time = false;
        result = false;
    }
    if(valiResult = validate_season(cou_sea)){
        showValidateError();
        //$("input[id = 'cou_sea']").next(".hint").html(valiResult);
        time = false;
        result = false;
    }
    if(!time){
        $("input[id = 'cou_sea']").next(".hint").html("请选择时间");
    }


    if(valiResult = validate_null(cou_num)){
        showValidateError();
        $("input[id = 'cou_num']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(cou_des)){
        showValidateError();
        $("textarea[id = 'cou_des']").next(".hint").html(valiResult);
        result = false;
    }

    return result;
}

function validatePwd() {
    var result = true;

    var old_pwd = $("input[name='old_pwd']").val();
    var new_pwd = $("input[name='new_pwd']").val();
    var new_pwd_repeat = $("input#new_pwd_repeat").val();

    var valiResult;
    if(valiResult = validate_null(old_pwd)){
        showValidateError();
        $("input[name='old_pwd']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(new_pwd)){
        showValidateError();
        $("input[name='new_pwd']").next(".hint").html(valiResult);
        result = false;
    }
    if(valiResult = validate_null(old_pwd)){
        showValidateError();
        $("input#new_pwd_repeat").next(".hint").html(valiResult);
        result = false;
    }
    if(new_pwd != new_pwd_repeat) {
        $("input[name='new_pwd']").next(".hint").html("两次密码输入不一致");
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