/**
 * Created by Lenovo on 2016/2/16.
 */
function validate_null(str){
    if ( str == "" ) return "内容为空";
    var regu = "^[ ]+$";
    var re = new RegExp(regu);
    if(re.test(str)){
        return "内容为空";
    }else {
        return null;
    }
}

function validate_email(str){
    if(validate_null(str)){
        return "内容为空";
    }
    var myReg = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
    if(myReg.test(str)) return null;
    return "邮件格式错误";
}

function validate_time(start, end, startEdge){
    if(validate_null(start) || validate_null(end)){
        return "内容为空";
    }
    startEdge = startEdge || "1900-01-01";

    var startArray = start.split('-');
    var startDate = new Date(startArray[0],startArray[1]-1,startArray[2]);
    var endArray = end.split('-');
    var endDate = new Date(endArray[0],endArray[1]-1,endArray[2]);
    var edgeArray = startEdge.split('-');
    var edgeDate = new Date(edgeArray[0],edgeArray[1]-1,edgeArray[2]);

    if(endDate.getTime() < startDate.getTime()){
        return "结束日期不能早于开始日期";
    }else {
        return null;
    }
}

function validate_num(value,startEdge,endEdge) {
    if(validate_null(value)){
        return "内容为空";
    }
    var reg = new RegExp("^[0-9]*$");
    if(reg.test(value)) {
        var num = Number(value);
        if(num < startEdge || num > endEdge){
            return "数值超出边界";
        }
        return null;
    }
    return "包含非数字字符";
}

function validate_aca(str){
    if (str == '院系'){
        return "请选择院系";
    }else {
        return null;
    }
}

function validate_spe(str){
    if (str == '请选择专业'){
        return "请选择专业";
    }else {
        return null;
    }
}

function validate_grade(str){
    if (str == '年级'){
        return "请选择年级";
    }else {
        return null;
    }
}

function validate_year(str){
    if (str == '年份'){
        return "请选择时间";
    }else {
        return null;
    }
}

function validate_season(str){
    if (str == '季节'){
        return "请选择时间";
    }else {
        return null;
    }
}

function validate_teacher(str){
    if (str == '请选择教师'){
        return "请选择教师";
    }else {
        return null;
    }
}

function  validate_phone(str){
    //alert("kong");
    if(validate_null(str)){
        return "内容为空";
    }
    var reg = new RegExp("^[0-9]*$");
    if(reg.test(str)){
        if(str.length != 11){
            return "请输入11位手机号";
        }
        return null;
    }
    return "包含非法字符";
}

function  validate_name(str){
    //alert("kong");
    if(validate_null(str)){
        return "内容为空";
    }
    var reg = new RegExp("^[\u4E00-\u9FA5]{2,10}$");
    if(reg.test(str)){
        return null;
    }

    return "请输入2-10位的中文名";
}

function validate_pwd(str){
    //if (s.length > 20 || s.length < 6){
    //    return "请输入6-20位的密码"
    //}

    var reg = new RegExp("^[a-zA-Z0-9]{6,20}$");
    if(reg.test(str)){
        return null;
    }
    return "密码为6-20位，由数字字母组成";
}

function showValidateError(){
    showStateBar("danger","信息填写错误");
}