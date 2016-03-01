/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function (){
    $(document).on("click", ".preview-btn", function () {
        //jQuery.ajax({
        //    data: $(this).attr("data-id"),
        //    url: "assignment_see",
        //    type: "get",
        //    success: function(msg){
        //        $("#preview-class-num").html(msg['homeworkNum'] + " - " +msg['homeworkName']);
        //        $("#preview-name").html(msg['studentName']);
        //        $("#preview-time").html("于" + msg['time'] + "提交");
        //        $("#preview-pdf").attr("src","__PUBLIC__/plugins/generic/web/viewer.html?file=../../../uploads/assignments/"+msg['pdfUrl']);
        //        $("#preview-modal").fadeIn();
        //        $("body").css("overflow","hidden");
        //    }
        //});
        $("#preview-modal").fadeIn();
        $("body").css("overflow", "hidden");
    });
    $(document).on("click",".preview-wrapper .close-btn",function(){
        $(".preview-wrapper").fadeOut(function(){
            $("body").css("overflow","auto");
        });
    });
});