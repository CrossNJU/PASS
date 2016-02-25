/**
 * Created by Lenovo on 2016/2/17.
 */
$(document).ready(function (){
    $('.file_submit').click(function(){$('.file').trigger('click');});
    $('.file').change(function(){$('.file_text').val($('.file').val());});
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
    function cancelFunc (){
        $(".dialog-wrapper").fadeOut(function(){
            $("body").css("overflow","auto");
            $(".modal-wrapper").remove();
        });
    };
    $(".dialog .btn").on("click",cancelFunc);
    $(".dialog .close-btn").on("click",cancelFunc);
}

