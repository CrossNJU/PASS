/**
 * Created by Lenovo on 2016/2/17.
 */
$(document).ready(function (){
    //判断是否需要显示状态栏
    if(msg != ""){
        showStateBar(type,msg);
    }
    //上传文件
    $('.file_submit').click(function(){$('.file').trigger('click');});
    $('.file').change(function(){$('.file_text').val($('.file').val());});

    //关闭弹窗
    $(document).on("click",".dialog .btn",closeFunc);
    $(document).on("click",".modal-wrapper .close-btn",closeFunc);

    //添加意见反馈窗口的监听
    $(document).on("click",".feedback-btn",function() {
        showFeedbackDialog();
    });

    //设置页面最小高度
    minHeight();
    $(window).resize(minHeight);

    $(".rect").each(function() {
        var height = $(this).parent().height();
        $(this).css("height",height+"px");
    });

    $("input[type=submit]").click(function() {
        this.addClass("btn-disabled");
    });
});

function showStateBar(type,text){
    var barType = "respond-"+type;
    $("body").prepend("<div class='toast' style='top:-80px;'> <div class='respond "+barType+"'><p class='respond-text'>"+text+"</p></div></div>");
    $(".toast").animate({
        top: "+=80px",
    });
    $(".toast").delay(1500);
    $(".toast").animate({
        top: "-=80px"
    },function(){
        $(".toast").remove();
    })
}

function showDialog(text){
    $("body").prepend("<div class='modal-wrapper dialog-wrapper'> <div class='dialog'> <p class='warning-text'>"+text+"</p> <a href='javascript:void(0)' class='btn confirm-btn'>确认</a> <a href='javascript:void(0)' class='btn btn-active'>取消</a> </div> </div>");
    $('.dialog-wrapper').fadeIn();
    $("body").css("overflow","hidden");
    $(".dialog .btn").on("click",closeFunc);
    $(".dialog .close-btn").on("click",closeFunc);
}

function showFeedbackDialog() {

    $("body").append("" +
        "<div class='modal-wrapper feedback-wrapper'>" +
            "<div class='card feedback-card'>" +
                "<div class='card-info'>" +
                    "<h3 class='card-title'>意见反馈</h3>" +
                    "<a class='close-btn' href='javascript:void(0)'><b></b></a> " +
                    "<div id='feedback-content'> " +
                    "<textarea class='textarea feedback-textarea' placeholder='感谢你对哲学系作业提交系统的支持与关注，请留下你的宝贵信息帮助我们做进一步的改进'></textarea> " +
                    "</div> " +
                    "<a class='btn btn-primary feedback-confirm-btn'>提交反馈</a> " +
                    "<a class='btn cancel-btn'>取消反馈</a> " +
                "</div> " +
            "</div> " +
        "</div>");


    $(".feedback-confirm-btn").click(function () {
        var feedback = $(".feedback-textarea").val();

        if(feedback == "") {
            showStateBar("danger","反馈内容为空");
            return ;
        }

        if(!$(".feedback-confirm-btn").hasClass(".disabled-btn")) {
            $.ajax({
                url:"/PASS/Common/feedback",
                data:"feedback="+feedback,
                success:function(msg) {
                    if(msg == 1){
                        closeFunc();
                        showStateBar("success","谢谢您的反馈");
                    }else {
                        fail();
                        console.log(msg);
                    }
                },
                error: function() {
                    fail();
                }
            });

            $(".feedback-confirm-btn").addClass(".disabled-btn");
        }
        function fail() {
            showStateBar("danger","反馈失败，请稍后再试");
            $(".feedback-confirm-btn").removeClass(".disabled-btn");
        }
    });


    $(".feedback-wrapper").fadeIn();
    $("body").css("overflow","hidden");

    $(".feedback-wrapper .cancel-btn").click(closeFunc);
}


function closeFunc (){
    $(".modal-wrapper").fadeOut(function(){
        $("body").css("overflow","auto");
        $(".dialog-wrapper,.feedback-wrapper").remove();
    });
}

function minHeight(){
    //console.log(window.innerHeight);
    var minHeight = window.innerHeight - 280;
    $(".content").css("minHeight",minHeight+"px");
}

