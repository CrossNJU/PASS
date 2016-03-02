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

    select_spe[1][0] = new Option("中国语言文学类","");
    select_spe[1][1] = new Option("汉语言文学","");
    select_spe[1][2] = new Option("汉语言文学（作家班）","");
    select_spe[1][3] = new Option("戏剧影视文学","");
    select_spe[1][4] = new Option("中文基地","");

    select_spe[2][0] = new Option("历史学类","");
    select_spe[2][1] = new Option("历史学","");
    select_spe[2][2] = new Option("考古学","");
    select_spe[2][3] = new Option("考古学（文物鉴定）","");
    select_spe[2][4] = new Option("历史基地","");

    select_spe[3][0] = new Option("法学类","");
    select_spe[3][1] = new Option("法学","");
    select_spe[3][2] = new Option("法学（第二学位）","");
    select_spe[3][3] = new Option("法学（运动员班）","");

    select_spe[4][0] = new Option("哲学类","");
    select_spe[4][1] = new Option("哲学","");
    select_spe[4][2] = new Option("哲学基地","");

    select_spe[5][0] = new Option("新闻传播学类","");
    select_spe[5][1] = new Option("新闻学","");
    select_spe[5][2] = new Option("广告学","");
    select_spe[5][3] = new Option("广播电视新闻学","");
    select_spe[5][4] = new Option("新闻学（记者班）","");
    select_spe[5][5] = new Option("新闻学（运动员班）","");
    select_spe[5][6] = new Option("广播电视学","");
    select_spe[5][7] = new Option("新闻学（传媒实验班）","");

    select_spe[6][0] = new Option("公共管理类","");
    select_spe[6][1] = new Option("政治学与行政学","");
    select_spe[6][2] = new Option("行政管理","");
    select_spe[6][3] = new Option("国际政治","");
    select_spe[6][4] = new Option("政治学","");
    select_spe[6][5] = new Option("行政管理（劳动与社会保障方向）","");
    select_spe[6][6] = new Option("教育技术学","");
    select_spe[6][7] = new Option("劳动与社会保障","");
    select_spe[6][8] = new Option("行政管理（运动员班）","");
    select_spe[6][9] = new Option("行政管理（新疆班）","");
    select_spe[6][10] = new Option("政治学类","");

    select_spe[7][0] = new Option("文科类","");
    select_spe[7][1] = new Option("信息管理与信息系统","");
    select_spe[7][2] = new Option("图书馆学","");
    select_spe[7][3] = new Option("档案学","");
    select_spe[7][4] = new Option("编辑出版学","");
    select_spe[7][5] = new Option("理科类","");
    select_spe[7][6] = new Option("档案学（第二学士学位）","");

    select_spe[8][0] = new Option("社会学类","");
    select_spe[8][1] = new Option("社会学","");
    select_spe[8][2] = new Option("社会工作","");
    select_spe[8][3] = new Option("应用心理学","");

    select_spe[9][0] = new Option("经济学类","");
    select_spe[9][1] = new Option("经济学","");
    select_spe[9][2] = new Option("国际经济与贸易","");
    select_spe[9][3] = new Option("工商管理","");
    select_spe[9][4] = new Option("会计学","");
    select_spe[9][5] = new Option("财务管理","");
    select_spe[9][6] = new Option("金融学","");
    select_spe[9][7] = new Option("电子商务","");
    select_spe[9][8] = new Option("市场营销","");
    select_spe[9][9] = new Option("工商管理类","");
    select_spe[9][10] = new Option("工商管理（二学位）","");
    select_spe[9][11] = new Option("国际经济与贸易（二学位）","");
    select_spe[9][12] = new Option("工商管理（人力资源管理方向）","");
    select_spe[9][13] = new Option("保险","");
    select_spe[9][14] = new Option("金融工程","");
    select_spe[9][15] = new Option("经济学（产业经济方向）","");

    select_spe[10][0] = new Option("外语类","");
    select_spe[10][1] = new Option("英语","");
    select_spe[10][2] = new Option("俄语","");
    select_spe[10][3] = new Option("日语","");
    select_spe[10][4] = new Option("法语","");
    select_spe[10][5] = new Option("德语","");
    select_spe[10][6] = new Option("西班牙语","");
    select_spe[10][7] = new Option("英语（国际商务方向）","");
    select_spe[10][8] = new Option("应用英语强化班","");
    select_spe[10][9] = new Option("朝鲜语","");

    select_spe[11][0] = new Option("数学类","");
    select_spe[11][1] = new Option("数学与应用数学","");
    select_spe[11][2] = new Option("信息与计算科学","");
    select_spe[11][3] = new Option("统计学","");
    select_spe[11][4] = new Option("应用模块","");
    select_spe[11][5] = new Option("数学（英才计划）","");

    select_spe[12][0] = new Option("物理学类","");
    select_spe[12][1] = new Option("物理学","");
    select_spe[12][2] = new Option("应用物理学","");
    select_spe[12][3] = new Option("声学","");
    select_spe[12][4] = new Option("物理基地","");
    select_spe[12][5] = new Option("物理学（英才计划）","");

    select_spe[13][0] = new Option("化学类","");
    select_spe[13][1] = new Option("化学","");
    select_spe[13][2] = new Option("应用化学","");
    select_spe[13][3] = new Option("化学（基地）","");
    select_spe[13][4] = new Option("化学（英才计划）","");

    select_spe[14][0] = new Option("生物科学类","");
    select_spe[14][1] = new Option("生物技术","");
    select_spe[14][2] = new Option("生物科学","");
    select_spe[14][3] = new Option("生态学","");
    select_spe[14][4] = new Option("生物技术（与药科大学联办）","");
    select_spe[14][5] = new Option("生物科学（基地）","");
    select_spe[14][6] = new Option("生物科学（英才计划）","");

    select_spe[15][0] = new Option("地质学类","");
    select_spe[15][1] = new Option("地质学","");
    select_spe[15][2] = new Option("地球化学","");
    select_spe[15][3] = new Option("地质工程","");
    select_spe[15][4] = new Option("水文与水资源工程","");
    select_spe[15][5] = new Option("信息资源与计算机管理","");
    select_spe[15][6] = new Option("矿物岩石矿床","");
    select_spe[15][7] = new Option("地质学（古生物学方向）","");
    select_spe[15][8] = new Option("地下水科学与工程","");
    select_spe[15][9] = new Option("数字媒体技术","");
    select_spe[15][10] = new Option("地科基地","");
    select_spe[15][11] = new Option("地质学（地球物理学方向）","");

    select_spe[16][0] = new Option("地理科学类","");
    select_spe[16][1] = new Option("资源环境与城乡规划管理","");
    select_spe[16][2] = new Option("地理信息系统","");
    select_spe[16][3] = new Option("城市规划","");
    select_spe[16][4] = new Option("地理科学","");
    select_spe[16][5] = new Option("城市与资源学","");
    select_spe[16][6] = new Option("旅游管理","");
    select_spe[16][7] = new Option("海洋科学","");
    select_spe[16][8] = new Option("地理信息科学","");
    select_spe[16][9] = new Option("自然地理与资源环境","");
    select_spe[16][10] = new Option("地理基地","");
    select_spe[16][11] = new Option("海洋基地","");

    select_spe[17][0] = new Option("大气科学类","");
    select_spe[17][1] = new Option("大气科学","");
    select_spe[17][2] = new Option("应用气象学","");
    select_spe[17][3] = new Option("大气科学（基地）","");
    select_spe[17][4] = new Option("应用气象学（基地）","");

    select_spe[18][0] = new Option("电子信息类","");
    select_spe[18][1] = new Option("电子信息科学与技术","");
    select_spe[18][2] = new Option("声学","");
    select_spe[18][3] = new Option("通信工程","");
    select_spe[18][4] = new Option("生物医学工程","");
    select_spe[18][5] = new Option("微电子学","");
    select_spe[18][6] = new Option("微电子科学与工程","");

    select_spe[19][0] = new Option("材料类","");
    select_spe[19][1] = new Option("材料物理","");
    select_spe[19][2] = new Option("材料化学","");
    select_spe[19][3] = new Option("光电信息科学与工程","");
    select_spe[19][4] = new Option("新能源科学与工程","");
    select_spe[19][5] = new Option("生物医学工程","");
    select_spe[19][6] = new Option("光电信息工程","");

    select_spe[20][0] = new Option("环境科学与工程","");
    select_spe[20][1] = new Option("环境工程","");
    select_spe[20][2] = new Option("环境科学","");
    select_spe[20][3] = new Option("环境科学（环化）","");
    select_spe[20][4] = new Option("环境科学（环生）","");
    select_spe[20][5] = new Option("环境科学（环规）","");

    select_spe[21][0] = new Option("天文学类","");
    select_spe[21][1] = new Option("天文学","");
    select_spe[21][2] = new Option("空间科学与技术","");
    select_spe[21][3] = new Option("天文基地","");
    select_spe[21][4] = new Option("天文学（英才计划）","");

    select_spe[22][0] = new Option("计算机科学类","");
    select_spe[22][1] = new Option("计算机科学与技术","");
    select_spe[22][2] = new Option("计算机科学与技术（英才计划）","");

    select_spe[23][0] = new Option("医学类","");
    select_spe[23][1] = new Option("医学类（5+3）","");
    select_spe[23][2] = new Option("临床医学","");
    select_spe[23][3] = new Option("临床医学（5+3）","");
    select_spe[23][4] = new Option("临床医学（八年制）","");
    select_spe[23][5] = new Option("口腔医学","");
    select_spe[23][6] = new Option("口腔医学（5+3）","");
    select_spe[23][7] = new Option("临床医学（军总）","");
    select_spe[23][8] = new Option("基础医学","");

    select_spe[9][0] = new Option("应用文科强化班","");
    select_spe[9][1] = new Option("理科强化班","");
    select_spe[9][2] = new Option("理强（数理方向）","");
    select_spe[9][3] = new Option("理强（生物化学）","");
    select_spe[9][4] = new Option("英才计划（物理班）","");
    select_spe[9][5] = new Option("财务管理","");
    select_spe[9][6] = new Option("金融学","");
    select_spe[9][7] = new Option("电子商务","");
    select_spe[9][8] = new Option("市场营销","");
    select_spe[9][9] = new Option("工商管理类","");
    select_spe[9][10] = new Option("工商管理（二学位）","");
    select_spe[9][11] = new Option("国际经济与贸易（二学位）","");
    select_spe[9][12] = new Option("工商管理（人力资源管理方向）","");
    select_spe[9][13] = new Option("保险","");
    select_spe[9][14] = new Option("金融工程","");
    select_spe[9][15] = new Option("经济学（产业经济方向）","");

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





