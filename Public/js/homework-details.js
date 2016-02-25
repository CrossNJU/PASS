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
});