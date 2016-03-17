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
    startEdge = startEdge || (new Date()).toLocaleDateString();

    var startArray = start.split('-');
    var startDate = new Date(startArray[0],startArray[1]-1,startArray[2]);
    var endArray = end.split('-');
    var endDate = new Date(endArray[0],endArray[1]-1,endArray[2]);
    var edgeArray = startEdge.split('/');
    var edgeDate = new Date(edgeArray[0],edgeArray[1]-1,edgeArray[2]);

    console.log(startDate+" "+endDate+" "+edgeDate);

    if(startDate.getTime() < edgeDate.getTime()) {
        return "开始日期不能早于今日";
    }else if(endDate.getTime() < startDate.getTime()){
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
    if (str == '专业'){
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
        return "请选择年份";
    }else {
        return null;
    }
}

function validate_season(str){
    if (str == '季节'){
        return "请选择季节";
    }else {
        return null;
    }
}

function showValidateError(){
    showStateBar("danger","信息填写错误");
}