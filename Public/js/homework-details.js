/**
 * Created by Lenovo on 2016/2/24.
 */
$(document).ready(function (){

    /*
    添加收起展开评语的按钮监听
     */
    $(document).on("click",".packup-btn",function(){
        var btn = $(this);
        var comment = btn.parent();
        var contentStr = btn.html().split('/');
        if(contentStr[1] == "收起评语"){
            btn.html(contentStr[0]+"/展开评语");
            comment.css("overflow","hidden");
            comment.animate({height: "40px",});
        }else if(contentStr[1] == "展开评语"){
            btn.html(contentStr[0]+"/收起评语");
            comment.css("overflow","auto");
            var oldHeight = comment[0].scrollHeight-(comment.outerHeight()-comment.height());
            comment.animate({height: oldHeight+"px"});
        }
    });

    /*
    添加移除作业的按钮监听
     */
    $(document).on("click",".delete-btn",function() {
        var hwid = $(this).attr("data-hwid");
        var btn = $(this);
        showDialog("是否移除这个作业?");
        $(".confirm-btn").click(function() {
            jQuery.ajax({
                async: false,
                url: "assignment_delete",
                data: "assignment_id=" + hwid,
                dataType: "json",
                success: function (msg) {
                    if (msg == 1) {
                        btn.parent(".homework").slideUp(function () {
                            btn.parent(".homework").remove();
                        });
                        showStateBar("success", "作业移除成功");
                    } else {
                        showStateBar("danger", "作业移除失败");
                    }
                },
            });
        });
    });


    /*
    添加提醒学生重新提交的按钮监听
     */
    var submitAgainFn;
    $(document).on("click",".again-btn",submitAgainFn = function(){
        var btn = $(this);
        var studentId = btn.attr("data-stuid");
        var homeworkId = btn.attr("data-hwid");
        showDialog("确定以邮件提醒学生重新提交作业？");
        $(".confirm-btn").click(function() {
            jQuery.ajax({
                async:true,
                type:"post",
                url:"../../reupload",
                data:"stu_id=S1"+"&assignment_id="+homeworkId,
                success: function(msg){
                    if(msg == 1){
                        showStateBar("success","提醒重新提交成功");
                    }else if(msg == 0) {
                        showStateBar("danger","提醒重新提交失败，请稍后再试");
                    }
                },
            });
            btn.addClass("btn-disabled");
            $(document).unbind("click",submitAgainFn);
        })
    });

    /*
    添加批量下载的按钮监听
     */
    $(document).on("click",".batch-btn",function(){
        var btn = $(this);
        var homeworkId = btn.attr("data-id");
        $.ajax({
            async:true,
            url:"../../download",
            data:"assignment_id=" + homeworkId,
            type:"get",
            success: function (msg) {
                window.location.href = publicUrl+"/uploads/"+msg;
            }
        })
    })

    /*
    添加查看学生信息的按钮监听
     */
    $(document).on("mouseover",".stu-info-text",function(event){
        $.ajax({
            url:"../../check_student_info",
            data:"stu_id=S1",
            type:"post",
            success: function(){
                var card = $(".student-card");
                var top = event.clientY-card.height()-70;
                var left = event.clientX-card.width()/2;
                card.css("top",top+"px").css("left",left+"px");
                card.fadeIn();
            }
        })

    })
    $(document).on("mouseout",".stu-info",function(event){
        //$(".student-card").css("top",event.clientY+"px","left",event.clientX+"px");
        $(".student-card").fadeOut();
    })
});