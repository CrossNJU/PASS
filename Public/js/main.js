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

    //设置页面最小高度
    minHeight();
    $(window).resize(minHeight);
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
    function cancelFunc (){
        $(".dialog-wrapper").fadeOut(function(){
            $("body").css("overflow","auto");
            $(".modal-wrapper").remove();
        });
    };
    $(".dialog .btn").on("click",cancelFunc);
    $(".dialog .close-btn").on("click",cancelFunc);
}

function closeFunc (){
    $(".modal-wrapper").fadeOut(function(){
        $("body").css("overflow","auto");
        $(".dialog-wrapper").remove();
    });
}

function minHeight(){
    //console.log(window.innerHeight);
    var minHeight = window.innerHeight - 280;
    $(".content").css("minHeight",minHeight+"px");
}
