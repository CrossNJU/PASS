/**
 * Created by Lenovo on 2016/2/17.
 */
$(document).ready(function () {
    $(document).on("click",".join-btn",fnClick=function (){
        var btn = $(this);
        var id = btn.attr("data-id");
        var status = btn.attr("data-status");
        if(status == "join"){
            jQuery.ajax({
                async: false,
                data: "course_id="+id,
                url: "/PASS/index.php/Home/Student/course_add",
                type: "post",
                success: function (msg) {
                    if (msg == -1) {
                        showStateBar("danger", "课程添加失败");
                    } else if(msg == 1) {
                        showStateBar("success", "课程添加成功");
                        btn.attr("data-status","remove");
                        btn.html("已添加课程");
                        btn.css("width","90px");
                        btn.hover(function(){
                            $(this).html("移除");
                        }, function(){
                            btn.html("已添加课程");
                        });
                    }
                },
                error: function () {
                    showStateBar("danger", "课程添加失败");
                },
            });
        }else if(status == "remove") {
            jQuery.ajax({
                async: false,
                data: "course_id="+id,
                url: "/PASS/index.php/Home/Student/course_remove",
                type: "post",
                success: function (msg) {
                    if (msg == -1) {
                        showStateBar("danger", "课程退选失败");
                    } else if(msg == 1) {
                        showStateBar("success", "课程退选成功");
                        btn.attr("data-status","join");
                        btn.unbind("mouseenter").unbind("mouseleave");
                        btn.html("加入课程");
                        btn.css("width","auto");
                    }
                },
                error: function () {
                    showStateBar("danger", "课程退选失败");
                },
            });
        }

    });

    $(document).on("click",".search-btn",function(){
        var bar = $(".search-bar");
        if(bar.attr("value")!=""){
            $.post("course_in", {search:bar.attr("value")});
        }
    });
});

