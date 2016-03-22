/**
 * Created by Lenovo on 2016/2/18.
 */
$(document).ready(function () {
    $(document).on("click", ".packup-btn", function () {
        var btn = $(this);
        $(this).parent().siblings(".homework").slideToggle();
        if (btn.html() == "收起作业") {
            $(this).html("展开作业");
        } else {
            $(this).html("收起作业");
        }
    });

    $(document).on("click", ".remove-btn", function () {
        var btn = $(this);
        var id = btn.attr("data-id");
        showDialog("确定退选这个课程？");
        $(".confirm-btn").click(function(){
            jQuery.ajax({
                async: false,
                data: "course_id=" + id,
                url: "/PASS/Student/course_remove",
                type: "post",
                success: function (msg) {
                    if (msg == -1) {
                        showStateBar("danger", "课程退选失败");
                    } else if (msg == 1) {
                        showStateBar("success", "课程退选成功");
                        btn.parents(".card").slideUp(function () {
                            btn.parents(".card").remove();
                        });
                    }
                },
                error: function () {
                    showStateBar("danger", "课程退选失败");
                },
            });
        });
    });

    $(document).on("click", ".preview-btn", function () {
        var url = $(this).attr("data-url");
        var type = $(this).attr("data-type");
        var num = $(this).attr("data-classNum");
        var name = $(this).attr("data-name");
        var time = $(this).attr("data-time");
        $("#preview-class-num").html(num);
        $("#preview-name").html(name);
        $("#preview-time").html("于"+time+"提交");

        if(type == 'mp4'){
            $("#preview-content").html(
                "<video id='really-cool-video' class='video-js vjs-default-skin' controls = 'controls'preload='auto' height='360' data-setup='{}'>"+
                "<source src='"+publicUrl+"/uploads/"+url+"' type='video/mp4'>"+
                "</video>");
        }else {
            $("#preview-content").html("<iframe class='pdf' src='"+publicUrl+"/plugins/generic/web/viewer.html?file="+publicUrl+"/uploads/"+url+"'></iframe>");
        }
        $("#preview-modal").fadeIn();
        $("body").css("overflow", "hidden");
    });

    $(document).on("click",".preview-wrapper .close-btn",function(){
        $(".preview-wrapper").fadeOut(function(){
            $("body").css("overflow","auto");
            if($("#really-cool-video").length){
                $("#really-cool-video")[0].pause();
            }
        });
    });
});