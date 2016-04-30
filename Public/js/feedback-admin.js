/**
 * Created by Moo on 2016/4/30.
 */

$(document).ready(function(){
    $(".feedback-text").each(function () {
        console.log($(this)[0].clientHeight);
        console.log($(this).css("line-height").replace("px", ""));
        if(parseInt($(this)[0].clientHeight,10) > parseInt($(this).css("line-height").replace("px", ""), 10)*2) {
            var val = $(this).html();
            $(this).attr("data-val", val);
            $clamp($(this)[0], {clamp: 2, useNativeClamp: false, truncationChar: ' ', truncationHTML: "... <a href='javascript:void(0)' class='expand-link'>展开</a>"});
        }
    })

    $(document).on('click','.expand-link',function () {
        var text = $(this).parent(".feedback-text");
        text.html(text.attr("data-val")+"  <a href='javascript:void(0)' class='packUp-link'>收起</a>");
    })

    $(document).on('click','.packUp-link',function () {
        var text = $(this).parent(".feedback-text");
        text.html(text.attr("data-val"));
        $clamp(text[0], {clamp: 2, useNativeClamp: false, truncationChar: ' ', truncationHTML: "... <a href='javascript:void(0)' class='expand-link'>展开</a>"});
    })

});