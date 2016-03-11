/**
 * Created by Lenovo on 2016/3/5.
 */
function checkRegister(){
    //alert("inin")
    if(document.getElementById("add_id").value == ""||document.getElementById("add_id").value == null){
        showStateBar("danger","请输入学号");
        //this.stu_id.focus();
        return false;
    }
    if(document.getElementById("add_name").value == ""||document.getElementById("add_name").value == null){
        showStateBar("danger","请输入姓名");
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
    if($('#add_grade option:selected').text() == '年级'){
        showStateBar("danger","请输入年级");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("add_email").value == ""||document.getElementById("add_email").value == null){
        showStateBar("danger","请输入邮箱");
        //this.grade.focus();
        return false;
    }
    if(!/^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(document.getElementById("add_email").value)){
        showStateBar("danger","邮箱格式好像哪里不对");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("add_phone").value == ""||document.getElementById("add_phone").value == null){
        showStateBar("danger","请填写手机");
        //this.grade.focus();
        return false;
    }
    if(document.getElementById("add_pwd").value == ""||document.getElementById("add_pwd").value == null){
        showStateBar("danger","请填写密码");
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