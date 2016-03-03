/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    //window.onload=function(){
    //    if(<{$msg}> == ''){
    //
    //    }
    //
    //    alert(userName);
    //}
    $(document).on("click",".admin-remove-btn",function(){
        var btn = $(this);
        console.log($(this));
        var id = btn.attr("data-id");
        jQuery.ajax({
            async: false,
            data: "stu_id="+id,
            url:"stu_del",
            type: "post",
            success: function(msg){
                if(msg == -1){
                    showStateBar("danger","学生删除失败");
                }else if(msg == 1){
                    showStateBar("success","学生删除成功");
                    btn.parent(".homework").slideUp(function(){
                        btn.parents(".homework").remove();
                    })
                }
            },
            error: function(){
                showStateBar("danger","学生删除失败");
            },
        });
    });

    $(document).on("click", ".up", function () {
        var btn = $(this);
        $(this).siblings('.test').children('.test-1').slideToggle();
        if (btn.html() == "收起选课情况") {
            $(this).html("展开选课情况");
        } else {
            $(this).html("收起选课情况");
        }
    });


})

function show(){
    var $p1 = $("#msg").val();
    var $p2 = $("#type").val();
    if ($p1!=""){
        showStateBar($p2,$p1);
    }
}
