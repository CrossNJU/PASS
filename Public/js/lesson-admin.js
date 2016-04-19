/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    $(document).on("click",".admin-remove-btn",function(){
        var btn = $(this);
        var id = btn.attr("data-id");
        showDialog("确定删除该课程？");
        $(".confirm-btn").click(function(){
            jQuery.ajax({
                async: false,
                data: "course_id="+id,
                url:rootUrl+"/Administer/course_del",
                type: "post",
                success: function(msg){
                    if(msg == -1){
                        showStateBar("danger","课程删除失败");
                    }else if(msg == 1){
                        showStateBar("success","课程删除成功");
                        btn.parent(".homework").slideUp(function(){
                            btn.parents(".homework").remove();
                        })
                    }
                },
                error: function(){
                    showStateBar("danger","课程删除失败");
                },
            });
        });
    });


    $(document).on("click",".download-hwk",function(){
        var asid = $(this).parent().next().text();
        console.log($(this));

        jQuery.ajax({
            async: false,
            data: "assignment_id="+asid,
            url:"download",
            type: "post",
            success: function(msg){
                if (msg == 'wrong'){
                    showStateBar("warning","暂无作业");
                }else window.location.href = "http://localhost/PASS/" + msg;
            },
            error: function(){
                showStateBar("danger","批量下载失败");
            }
        });
    });

    $(document).on("click",".stu-btn",function() {
        var btn = $(this);
        var id = btn.attr("data-id");
        var classMsg = btn.attr("data-class");

        $.ajax({
            async: true,
            data: "course_id="+id,
            url: rootUrl+"/Administer/course_student",
            success: function(stus) {
                $("body").append("" +
                    "<div class='modal-wrapper select-wrapper'>" +
                        "<div class='card select-card'>" +
                            "<h3 class='card-title'>"+classMsg+" 选课情况</h3>" +
                            "<a class='close-btn' href='javascript:void(0)'><b></b></a>" +
                            "<div class='student-table'>" +
                            "</div>" +
                        "</div>" +
                    "</div>");

                for(var i = 0; i < stus.length; i++) {
                    $(".student-table").append(""+
                        "<div class='student-table-cell'>" +
                            "<div class='num'>"+(i+1)+"</div>"+
                            "<p class='homework-title'>"+stus[i]['name']+"</p>" +
                            "<p class='stu-info comment'>"+stus[i]['academy']+" "+stus[i]['speciality']+"</p>" +
                        "</div>");
                }
                if(stus.length % 2 == 1) {
                    $(".student-table").append(""+
                        "<div class='student-table-cell student-table-cell-invisible'>" +
                            "<div class='num'>0</div>"+
                            "<p class='homework-title'>Nothing</p>" +
                            "<p class='stu-info comment'>Nothing</p>" +
                        "</div>");
                }
                if(stus.length == 0) {
                    $(".student-table").append("<p class='no-tip'>本课程暂无选课学生</p>");
                }


                $(".select-wrapper").fadeIn();
            }
        })
    })


})






