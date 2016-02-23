/**
 * Created by Moo on 2016/2/13.
 */

$(document).ready(function() {

    $(".packup-btn").click(function () {
        var btn = $(this);
        $(this).parent().siblings(".homework").slideToggle();
        if (btn.html() == "收起作业") {
            $(this).html("展开作业");
        }else {
            $(this).html("收起作业");
        }
    });

    $(".delete-btn").click(function() {
        var hwid = $(this).attr("data-hwid");
        var btn = $(this);
        jQuery.ajax({
            async:false,
            url:"assignment_delete",
            data:"assignment_id="+hwid,
            dataType:"json",
            success:function (msg){
                var statebar = undefined;
                if(msg == "delete success!"){
                    btn.parent(".homework").slideUp(function(){
                        btn.parent(".homework").remove();
                    });
                    showStateBar("success","作业删除成功");
                }else {
                    showStateBar("success","作业删除失败");
                }
            },
        });
    });
});
