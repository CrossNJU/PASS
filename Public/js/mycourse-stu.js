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
                url: "course_remove",
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
        //jQuery.ajax({
        //    data: $(this).attr("data-id"),
        //    url: "assignment_see",
        //    type: "get",
        //    success: function(msg){
        //        $("#preview-class-num").html(msg['homeworkNum'] + " - " +msg['homeworkName']);
        //        $("#preview-name").html(msg['studentName']);
        //        $("#preview-time").html("于" + msg['time'] + "提交");
        //        $("#preview-pdf").attr("src",msg['pdfUrl']);
        //        $("#preview-modal").fadeIn();
        //        $("body").css("overflow","hidden");
        //    }
        //});
        $("#preview-modal").fadeIn();
        $("body").css("overflow", "hidden");
    });
    $(document).on("click",".preview-wrapper .close-btn",function(){
        $(".preview-wrapper").fadeOut(function(){
            $("body").css("overflow","auto");
        });
    });
});