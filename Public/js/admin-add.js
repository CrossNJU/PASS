/**
 * Created by Lenovo on 2016/2/24.
 */
    //var valid = false;
    //$('#add-tea').click(function(){
    //    alert('in');
    //    if(validate_null($('#tea_id').val())){
    //        valid = true;
    //        alert("id为空");
    //    }
    //    if(validate_null($('#tea_name').val())){
    //        valid = true;
    //        alert("name为空");
    //    }
    //    if($('#tea_aca  option:selected').text() == '院系'){
    //        valid = true;
    //        alert("aca为空");
    //    }
    //    if($('#tea_spe option:selected').text() == '专业'){
    //        valid = true;
    //        alert("spe为空");
    //    }
    //    if(validate_email($('#tea_email').val())||validate_null($('#tea_email').val())){
    //        valid = true;
    //        alert("email为空或不合法");
    //    }
    //    if(validate_null($('#tea_pwd').val())){
    //        valid = true;
    //        alert("pwd为空");
    //    }
    //})
    //$("#add-tea").attr("disabled", true);
    //if(valid == true){
    //    $("#add-tea").attr("disabled", true);
    //    return false;
    //}else{
    //    $("#add-tea").attr("disabled", false);
    //    return true;
    //}
function redirec(x){
    var select_aca_len = document.aca_spe_form.aca.options.length;
    var select_spe = new Array(select_aca_len);

    for(i = 0;i < select_aca_len;i++){
        select_spe[i] = new Array();
    }
    select_spe[0][0] = new Option("院系","");

    select_spe[1][0] = new Option("aaa","");


        var temp = document.aca_spe_form.spe;
        for(i = 0;i < select_spe[x].length;i++){
            temp.options[i] = new Option(select_spe[x][i].text,
                select_spe[x][i].value);
            temp.options[0].selected = true;
        }
}
    //function redirec(x) {
    //    var select1_len = document.frm.s1.options.length;
    //    var select2 = new Array(select1_len);
    //    for (i = 0; i < select1_len; i++) {
    //        select2[i] = new Array();
    //    }
    //    select2[0][0] = new Option("请选择", " ");
    //
    //    select2[1][0] = new Option("PHP", " ");
    //    select2[1][1] = new Option("ASP", " ");
    //    select2[1][2] = new Option("JSP", " ");

    //    var temp = document.frm.s2;
    //    for (i = 0; i < select2[x].length; i++) {
    //        temp.options[i] = new Option(select2[x][i].text, select2[x][i].value);
    //    }
    //    temp.options[0].selected = true;
    //}



//$(document).ready(function () {
    //$(document).on("click","#add-stu-btn",fnClick=function (){
    //    if(<{$msg}> == "")

//        if(state == "join"){
//            jQuery.ajax({
//                async: false,
//                data: "course_id="+id,
//                url: "course_add",
//                type: "post",
//                success: function (msg) {
//                    if (msg == -1) {
//                        showStateBar("danger", "课程添加失败");
//                    } else if(msg == 1) {
//                        showStateBar("success", "课程添加成功");
//                        btn.attr("data-state","remove");
//                        btn.html("已添加课程");
//                        btn.css("width","90px");
//                        btn.hover(function(){
//                            $(this).html("移除");
//                        }, function(){
//                            btn.html("已添加课程");
//                        });
//                    }
//                },
//                error: function () {
//                    showStateBar("danger", "课程添加失败");
//                },
//            });
//        }else if(state == "remove") {
//            jQuery.ajax({
//                async: false,
//                data: "course_id="+id,
//                url: "course_remove",
//                type: "post",
//                success: function (msg) {
//                    if (msg == -1) {
//                        showStateBar("danger", "课程退选失败");
//                    } else if(msg == 1) {
//                        showStateBar("success", "课程退选成功");
//                        btn.attr("data-state","join");
//                        btn.unbind("mouseenter").unbind("mouseleave");
//                        btn.html("加入课程");
//                        btn.css("width","auto");
//                    }
//                },
//                error: function () {
//                    showStateBar("danger", "课程退选失败");
//                },
//            });
//        }
//
//    //});
//
//    $(document).on("click",".search-btn",function(){
//        var bar = $(".search-bar");
//        if(bar.attr("value")!=""){
//            $.post("course_in", {search:bar.attr("value")});
//        }
//    });
//});





