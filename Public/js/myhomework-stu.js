/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function (){
    $(document).on("click", ".preview-btn", function () {
        var url = $(this).attr("data-url");
        var type = $(this).attr("data-type");
        var num = $(this).attr("data-classNum");
        var name = $(this).attr("data-name");
        var time = $(this).attr("data-time");
        $("#preview-class-num").html(num);
        $("#preview-name").html(name);
        $("#preview-time").html("于"+time+"提交");

        if(type == 'mp4'){
            $("#preview-content").html(
                "<video id='really-cool-video' class='video-js vjs-default-skin' controls = 'controls'preload='auto' height='360' data-setup='{}'>"+
                    "<source src='"+publicUrl+"/uploads/"+url+"' type='video/mp4'>"+
                "</video>");
        }else {
            $("#preview-content").html("<iframe class='pdf' src='"+publicUrl+"/plugins/generic/web/viewer.html?file="+publicUrl+"/uploads/"+url+"'></iframe>");
        }
        $("#preview-modal").fadeIn();
        $("body").css("overflow", "hidden");
    });
    $(document).on("click",".preview-wrapper .close-btn",function(){
        $(".preview-wrapper").fadeOut(function(){
            $("body").css("overflow","auto");
            $("#really-cool-video")[0].pause();
        });
    });
});