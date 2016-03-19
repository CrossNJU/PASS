/**
 * Created by Moo on 2016/2/13.
 */

$(document).ready(function () {

    $(".packup-btn").click(function () {
        var btn = $(this);
        $(this).parent().siblings(".homework").slideToggle();
        if (btn.html() == "收起作业") {
            $(this).html("展开作业");
        } else {
            $(this).html("收起作业");
        }
    });

    $(".delete-btn").click(function () {
        var hwid = $(this).attr("data-hwid");
        var btn = $(this);
        showDialog("是否删除这个作业?");
        $(".confirm-btn").click(function() {
            jQuery.ajax({
                async: false,
                url: "/PASS/index.php/Home/Teacher/assignment_delete",
                data: "assignment_id=" + hwid,
                dataType: "json",
                success: function (msg) {
                    if (msg == 1) {
                        btn.parent(".homework").slideUp(function () {
                            btn.parent(".homework").remove();
                        });
                        showStateBar("success", "作业删除成功");
                    } else {
                        showStateBar("danger", "作业删除失败");
                    }
                },
            });
        });
    });
});
