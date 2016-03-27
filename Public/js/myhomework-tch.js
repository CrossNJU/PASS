/**
 * Created by Lenovo on 2016/2/16.
 */
$(document).ready(function() {
    $(".delete-btn").click(function() {
        var hwid = $(this).attr("data-hwid");
        var btn = $(this);
        showDialog("是否移除这个作业?");
        $(".confirm-btn").click(function() {
            jQuery.ajax({
                async: false,
                url: rootUrl+"/Teacher/assignment_delete",
                data: "assignment_id=" + hwid,
                success: function (msg) {
                    if (msg == 1) {
                        btn.parents(".card").slideUp(function () {
                            btn.parents(".card").remove();
                        });
                        showStateBar("success", "作业移除成功");
                    } else {
                        showStateBar("danger", "作业移除失败");
                    }
                },
            });
        });
    });
});