/**
 * Created by Lenovo on 2016/3/6.
 */


$(document).ready(function(){
    var aca = $("#tea_aca_temp").val();
    var spe = $("#tea_spe_temp").val();
    //alert(aca);
    //alert(spe);
    //$("#tea_aca option[value = aca]").attr("selected", true);
    //$("#tea_spe option[value = spe]").attr("selected", true);


    var s1 = document.getElementById("tea_aca");
    for(var i = 0;i < s1.length;i++){
        if(s1[i].value == aca){
            //alert("in");
            s1[i].selected = true;
            redirec(i);
            break;
        }
    }

    var s2 = document.getElementById("tea_spe");
    for(var i = 0;i < s2.length;i++){
        if(s2[i].value == spe){
            //alert("inspe");
            s2[i].selected = true;
            break;
        }
    }
})

/**
 * Created by Lenovo on 2016/3/5.
 */
function checkTea(){
    //alert("inin")
    if(document.getElementById("tea_id").value == ""||document.getElementById("tea_id").value == null){
        showStateBar("danger","请输入教师工号");
        //this.stu_id.focus();
        return false;
    }
    if(document.getElementById("tea_name").value == ""||document.getElementById("tea_name").value == null){
        showStateBar("danger","请输入教师姓名");
        //this.grade.focus();
        return false;
    }
    if($('#tea_aca  option:selected').text() == '院系'){
        //alert("院系");
        showStateBar("danger","请选择院系");
        return false;
    }
    if($('#tea_spe  option:selected').text() == '专业'){
        showStateBar("danger","请选择专业");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("tea_email").value == ""||document.getElementById("tea_email").value == null){
        showStateBar("danger","请输入邮箱");
        //this.grade.focus();
        return false;
    }
    if(!/^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(document.getElementById("tea_email").value)){
        showStateBar("danger","邮箱格式好像哪里不对");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("tea_phone").value == ""||document.getElementById("tea_phone").value == null){
        showStateBar("danger","请填写手机");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("tea_pwd").value == ""||document.getElementById("tea_pwd").value == null){
        showStateBar("danger","请填写密码");
        //this.grade.focus();
        return false;
    }
    return true;
}

function checkStu(){
    //alert("inin")
    if(document.getElementById("stu_id").value == ""||document.getElementById("stu_id").value == null){
        showStateBar("danger","请输入学号");
        //this.stu_id.focus();
        return false;
    }
    if(document.getElementById("stu_name").value == ""||document.getElementById("stu_name").value == null){
        showStateBar("danger","请输入姓名");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("stu_grade").value == ""||document.getElementById("stu_grade").value == null){
        showStateBar("danger","请输入年级");
        //this.grade.focus();
        return false;
    }
    if($('#tea_aca  option:selected').text() == '院系'){
        //alert("院系");
        showStateBar("danger","请选择院系");
        return false;
    }
    if($('#tea_spe  option:selected').text() == '专业'){
        showStateBar("danger","请选择专业");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("stu_email").value == ""||document.getElementById("stu_email").value == null){
        showStateBar("danger","请输入邮箱");
        //this.grade.focus();
        return false;
    }
    if(!/^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(document.getElementById("stu_email").value)){
        showStateBar("danger","邮箱格式好像哪里不对");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("stu_phone").value == ""||document.getElementById("stu_phone").value == null){
        showStateBar("danger","请填写手机");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("stu_pwd").value == ""||document.getElementById("stu_pwd").value == null){
        showStateBar("danger","请填写密码");
        //this.grade.focus();
        return false;
    }
    return true;
}

function checkLesson(){
    //alert("inin")
    if(document.getElementById("cou_name").value == ""||document.getElementById("cou_name").value == null){
        showStateBar("danger","请输入课程名");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("cou_tea").value == ""||document.getElementById("cou_tea").value == null){
        showStateBar("danger","请输入授课教师");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("cou_time").value == ""||document.getElementById("cou_time").value == null){
        showStateBar("danger","请输入授课时间");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("cou_num").value == ""||document.getElementById("cou_num").value == null){
        showStateBar("danger","请填参与人数");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("cou_des").value == ""||document.getElementById("cou_des").value == null){
        showStateBar("danger","请填写课程描述");
        //this.grade.focus();
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