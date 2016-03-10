/**
 * Created by Lenovo on 2016/2/24.
 */
$(document).ready(function (){
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

    $(document).on("click",".again-btn",function(){
        var btn = $(this);
        var studentId = btn.attr("data-stuid");
        var homeworkId = btn.attr("data-hwid");
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
    });

    $(document).on("click",".batch-btn",function(){
        var btn = $(this);
        var homeworkId = btn.attr("data-id");
        $.ajax({
            async:true,
            url:"../../download",
            data:"assignment_id=" + homeworkId,
            type:"get",
            success: function (msg) {
                window.location.href = publicUrl+"/upload/"+msg;
            }
        })
    })

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