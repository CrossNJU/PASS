/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    $(document).on("click",".admin-remove-btn",function(){
        var btn = $(this);
        var id = btn.attr("data-id");
        showDialog("确定删除该学生？");
        $(".confirm-btn").click(function(){
            jQuery.ajax({
                async: false,
                data: "stu_id="+id,
                url:"/PASS/Administer/stu_del",
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
    });

    $(document).on("click", ".up", function () {
        var btn = $(this);
        $(this).siblings('.test').children('.test-1').slideToggle();
        //$(this).siblings('.test').children('.teacher-class-num').css('margin-bottom','0px');

        if (btn.html() == "收起选课情况") {
            //$(this).siblings('.test').children('.teacher-class-num').css('margin-bottom','0px');
            $(this).html("展开选课情况");
        } else {
            //$(this).siblings('.test').children('.teacher-class-num').css('margin-bottom','14px');
            $(this).html("收起选课情况");
        }
    });


});

function show(){
    var $p1 = $("#msg").val();
    var $p2 = $("#type").val();
    if ($p1!=""){
        showStateBar($p2,$p1);
    }
}
